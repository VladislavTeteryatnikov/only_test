<?php

    /**
     * Класс маршрутизатор. Определяет controller и action в зависимости от переданного URL
     */

    class Router
    {
        /**
         * @var array Массив маршрутов
         */
        private $routes;

        /**
         * Конструктор
         */
        public function __construct()
        {
            require_once("configs/routes.php");
            $this->routes = $routes;
        }

        /**
         * Создает экземпляр контроллера и вызывает у него необходимый action в зависимости от переданного URL
         */
        public function run()
        {
            $requestedUrl = $_SERVER['REQUEST_URI'];
            foreach ($this->routes as $controller => $paths) {
                foreach ($paths as $url => $action) {
                    if (preg_match("~$url~", $requestedUrl)) {
                        $requestedController = new $controller();
                        $requestedAction = "action" . ucfirst($action);

                        if (!method_exists($requestedController, $requestedAction)) {
                            header("HTTP/1.0 404 Not Found");
                            header("HTTP/1.1 404 Not Found");
                            header("Status: 404 Not Found");
                            die();
                        }
                        $requestedController->$requestedAction();
                        break 2;
                    }
                }
            }
        }
    }