<?php

    class UserController
    {
        public object $userModel;

        private object $helper;

        public function __construct()
        {
            $this->userModel = new User;
            $this->helper = new Helper();
        }

        public function actionReg()
        {
            session_start();
            if (!isset($_SESSION['token'])) {
                $token = md5(uniqid(rand(), true));
                $_SESSION['token'] = $token;
            }

            //Пустой массив, куда будем помещать ошибки, возникающие при заполнении формы
            $errors = [];

            if (isset($_POST['login'])) {

                if ($_POST['token'] != $_SESSION['token']) {
                    header('Location:' . FULL_SITE_ROOT);
                    die();
                }

                $login = htmlentities($_POST['login']);
                $phone = htmlentities($_POST['phone']);
                $email = htmlentities($_POST['email']);
                $password = htmlentities($_POST['password']);
                $repeatPassword = htmlentities($_POST['password_confirmation']);


                if (empty($login) || empty($phone) || empty($email) || empty($password) || empty($repeatPassword)){
                    $errors[] = "Необходимо заполнить все поля";
                }

                if ($password !== $repeatPassword) {
                    $errors[] = "Пароли не совпадают";
                }
                 if (empty($errors)) {
                     $count = $this->userModel->checkIfUserExists($login, $phone, $email);

                     //Если нашлось совпадение, то выводим ошибку
                     if ((int)$count === 1) {
                         $errors[] = "Логин, телефон или email уже зарегистрированы";
                     }
                 }

                if (empty($errors)) {
                    //Хэшируем пароль и вносим данные пользователя в БД
                    $hashedPassword = md5($password);
                    $this->userModel->register($login, $phone, $email, $hashedPassword);

                    //Генерируем токен, устанавливаем куки
                    $token = Helper::generateToken();
                    $tokenTime = time() + 30 * 60;
                    $userInfo = $this->userModel->getUserInfo($email, $hashedPassword);
                    $userId = $userInfo['user_id'];

                    setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
                    setcookie("t", $token, time() + 2 * 24 * 3600, '/');
                    setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, '/');

                    header('Location:' . FULL_SITE_ROOT . 'auth/' );
                }
            }

            $title = "Регистрация";
            include_once("views/users/reg.html");
        }

        public function actionAuth()
        {
            session_start();
            if (!isset($_SESSION['token'])) {
                $token = md5(uniqid(rand(), true));
                $_SESSION['token'] = $token;
            }

            $errors = [];

            if (isset($_POST['phone_email'])) {

                if ($_POST['token'] != $_SESSION['token']) {
                    header('Location:' . FULL_SITE_ROOT);
                    die();
                }

                $phoneOrEmail = htmlentities($_POST['phone_email']);
                $password = htmlentities($_POST['password']);
                $hashedPassword = md5($password);

                $userInfo = $this->userModel->getUserInfo($phoneOrEmail, $hashedPassword);
                if ($userInfo['count'] === '0') {
                    $errors[] = "Такой связки не существует";
                }
                $token = $_POST['smart-token']; //Например, $_POST['smart-token'];
                if (!Helper::checkCaptcha($token)) {
                    $errors[] = "Капча не пройдена";
                }

                if (empty($errors)) {

                    $token = Helper::generateToken();
                    $tokenTime = time() + 3 * 60;
                    $userId = $userInfo['user_id'];
                    $this->userModel->auth($userId, $token, $tokenTime);

                    setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
                    setcookie("t", $token, time() + 2 * 24 * 3600, '/');
                    setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, '/');

                    header('Location:' . FULL_SITE_ROOT);;
                }
            }

            $title = "Авторизация";
            include_once("views/users/auth.html");
        }

        public function actionLogout()
        {
            if (isset($_COOKIE['uid']) && isset($_COOKIE['t'])) {
                $userId = htmlentities($_COOKIE['uid']);
                $token = htmlentities($_COOKIE['t']);
                $this->userModel->logout($userId, $token);
            }

            setcookie("uid", "", time() - 10, '/');
            setcookie("t", "", time() - 10, '/');
            setcookie("tt", 0, time() - 10, '/');
            header('Location:' . FULL_SITE_ROOT );;
        }

        public function actionAccount()
        {
            if (!Helper::checkIfUserAuthorized($this->userModel)){
                header('Location:' . FULL_SITE_ROOT);
                die();
            }

            session_start();
            if (!isset($_SESSION['token'])) {
                $token = md5(uniqid(rand(), true));
                $_SESSION['token'] = $token;
            }

            $userId = $_COOKIE['uid'];
            $userInfo = $this->userModel->getUserInfoById($userId);

            if (isset($_POST['login'])) {
                $errors = [];

                $login = htmlentities($_POST['login']);
                $phone = htmlentities($_POST['phone']);
                $email = htmlentities($_POST['email']);
                $password = !empty($_POST['password']) ? htmlentities($_POST['password']) : null;
                $repeatPassword = !empty($_POST['password_confirmation']) ? htmlentities($_POST['password_confirmation']) : null;

                if ($password !== $repeatPassword) {
                    $errors[] = "Пароли не совпадают";
                }

                if (empty($errors)) {
                    $hashedPassword = !empty($password) ? md5($password) : null;

                    $result = $this->userModel->edit($email, $login, $phone, $hashedPassword, $userId);
                    if ($result) {
                        header('Location:' . FULL_SITE_ROOT);
                    }
                }
            }

            $title = "Личный кабинет";
            include_once("views/users/account.html");
        }
    }
