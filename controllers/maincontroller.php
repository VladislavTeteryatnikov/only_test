<?php

    class MainController
    {
        public function actionIndex()
        {
            $title = "Главная";
            include_once("views/index.html");
        }
    }
