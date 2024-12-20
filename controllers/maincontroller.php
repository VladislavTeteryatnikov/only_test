<?php

    class MainController
    {
        private object $userModel;

        public function __construct()
        {
            $this->userModel = new User;
        }

        public function actionIndex()
        {
            $title = "Главная";
            include_once("views/index.html");
        }
    }
