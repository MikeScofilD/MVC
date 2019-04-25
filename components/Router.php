<?php 
    class Router{
        private $routes = 'helloRouter';
        public function __constructor()
        {
            echo "__constructor( this->routes = ".$this->routes." )</br>";
            $routesPath = ROOT.'/config/routes.php';
             $this->routes = include($routesPath);
        }
        // Return request string
        private function getURI(){
            if (!empty($_SERVER['REQUEST_URI'])) {
                return trim($_SERVER['REQUEST_URI'], '/');
            }
        }
        public function run()
        {
            echo "<pre>routes = ";
                print_r($this->routes);
            echo "</pre>";
             echo "</br>Class Router, method run</br>";

            //1)Получить строку запроса
            $uri = $this->getURI();
            echo "<br/>";
            echo "URI: ".$uri."<br/>";

            //2)Проверить наличие такого запроса в routes.php
            foreach ($this->routes as $uriPattern => $path) {

                 echo "</br>[Routers]: $uriPattern->$path";
                 echo "</br>$uriPattern =  $uri</br>";

                //Сравниваем $uriPattern и $uri
               if (preg_match("~$uriPattern~", $uri)) {

                   //3)Если есть совпадение, определить какой контролер
                   // и action обрабатывают запрос
                   $segments = explode('/',$path);
                   echo "<pre>Segments = ";
                    print_r($segments);
                   echo "</pre>";

                   $controllerName = array_shift($segments).'Controller';
                   $controllerName = ucfirst($controllerName);

                   $actionName = 'action'.ucfirst(array_shift($segments));
                   echo "</br>Класс: ".$controllerName;
                   echo "</br>Метод: ".$actionName."</br>";

                   //4)Подключить файл класса-контроллера
                   $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                   if (file_exists($controllerFile)){
                       include_once ($controllerFile);

                   }
                   //5)Создать обьект, вызвать метод(т.е action)
                   $controllerObject = new $controllerName;
                   $result = $controllerObject->$actionName();
                   if ($result != NULL)
                   {
                       break;
                   }
               }
            }


        }

    }
?>