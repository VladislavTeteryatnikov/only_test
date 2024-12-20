<?php

    class User
    {
        private $connect;

        public function __construct()
        {
            $this->connect = DB::getConnect();
        }

        public function checkIfUserExists(string $login, string $phone, string $email)
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `users`
                WHERE `user_login` = '$login'
                OR `user_phone` = '$phone'
                OR `user_email` = '$email';
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

        public function register(string $login, string $phone, string $email, string $hashedPassword)
        {
            $query = "
                INSERT INTO `users`
                SET `user_login` = '$login',
                    `user_phone` = '$phone',
                    `user_email` = '$email',
                    `user_password` = '$hashedPassword';
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getUserInfo(string $emailOrPhone, string $hashedPassword)
        {
            $query = "
                SELECT COUNT(*) AS `count`, `user_id`
                FROM `users`
                WHERE (`user_email` = '$emailOrPhone' OR `user_phone` = '$emailOrPhone')
                  AND `user_password` = '$hashedPassword';
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        public function auth(int $userId, string $token, int $tokenTime)
        {
            $query = "
                INSERT INTO `connects`
                SET `connect_user_id` = $userId,
                    `connect_token` = '$token',
                    `connect_token_time` = FROM_UNIXTIME($tokenTime);
            ";
            return mysqli_query($this->connect, $query);
        }

        public function logout($userId, $token)
        {
            $query = "
                DELETE FROM `connects`
                    WHERE `connect_user_id` = $userId
                        AND `connect_token` = '$token';
            ";
            return mysqli_query($this->connect, $query);
        }

    }