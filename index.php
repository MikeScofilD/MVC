<?php
    //FRONT CONTROLLER
    echo __DIR__.'</br>';
    //1.Общие Настройки
    ini_set('display_errors',1);
    error_reporting(E_ALL);

    //2.Подключение файлов систем   
    define('ROOT', dirname(__FILE__));
    // echo ROOT."</br>";
    require_once(ROOT.'/components/Router.php');

    //3.Установка соединения с БД

    //4.Вызов Router
    $router = new Router();
    $router->__constructor();
    $router->run();
