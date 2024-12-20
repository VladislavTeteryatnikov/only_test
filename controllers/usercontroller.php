<?php

    class UserController
    {
        public function __construct()
        {
            //
        }

        public function actionReg()
        {
            $title = "Регистрация";
            include_once("views/users/reg.html");
        }

        public function actionAuth()
        {
            $title = "Регистрация";
            include_once("views/users/auth.html");
        }
    }
