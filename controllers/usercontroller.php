<?php

    class UserController
    {
        public object $userModel;

        private object $helper;

        public function __construct()
        {
            $this->userModel = new User;
        }

        public function actionReg()
        {
            //Пустой массив, куда будем помещать ошибки, возникающие при заполнении формы
            $errors = [];

            if (isset($_POST['login'])) {
                $login = htmlentities($_POST['login']);
                $phone = htmlentities($_POST['phone']);
                $email = htmlentities($_POST['email']);
                $password = htmlentities($_POST['password']);
                $repeatPassword = htmlentities($_POST['password_confirmation']);

                //Производим валидацию данных
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
            $title = "Регистрация";
            include_once("views/users/auth.html");
        }
    }
