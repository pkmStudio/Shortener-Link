<?php

namespace app\core;

use app\core\View;


class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        // Подключаем файл с маршрутами.
        $routes = require 'app/config/routes.php';

        // Перебираем маршруты и отправляем их в метод add.
        foreach ($routes as $route => $params) {
            $this->add($route, $params);
        }
    }


    // Эта функция прогоняет массив routes и к ключам(ссылкам) добавляет символы. Для дальнейшего сравнения в match.
    public function add($route, $params)
    {
        // Здесь мы добавляем к строке route по 2 символа с каждой стороны, что бы сделать из этого регулярное выражение.
        $route = '#^'.$route.'$#';

        // Затем мы маршруты пишем в массив класса $this->routes уже в регулярном виде.
        $this->routes[$route] = $params;
    }


    // Эта функция проверяет, есть ли такой маршрут вообще?
    public function match()
    {
        // В переменную пишем глобальный массив, в котором смотрим часть ссылки после nameProject/, он же маршрут. И удаляем "/" в начале и конце.
        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');

        // !Для сервиса сокращения ссылки
        // ?Если озарит как сделать под общий вид - вернусь.
        if (preg_match('#^(s\/)([^\s@]*)$#', $url, $matches)) {
            $this->params['controller'] = 'link';
            $this->params['action'] = 'relocation';
            $this->params['link'] = $matches['2'];
            return true;
        }

        // Перебираем массив маршрутов(ссылок) уже в регулярном виде, которые есть у нас на сайте. 
        foreach ($this->routes as $route => $params) {
            // Если находим совпадение, то пишем параметры в перменную $params и возвращаем true.
            if (preg_match($route, $url , $matches)) {
                $this->params = $params;
                return true;
            }
        }

        // Если маршрут не найден возвращаем false.
        return false;
    }

    
    // Эта функция  создает нужный объект класса на основе маршрута и вызывает нужный метод.
    public function run()
    {
        // Вызываем метод, который проверит, есть ли нужный маршрут у нас в наличии.
        if($this->match()) {
            // Если вернулось true.

            // Делаем первую букву, названия контроллера, заглавной.
            $path = ucfirst($this->params['controller']);
            // Прописывааем полный путь к контроллеру.
            $path = "app\controllers\\{$path}Controller";

        } else {
            // Если вернулось false.
            View::errorCode(404);
        }

        // Делаем проверку на существование класса.
        if (class_exists($path)) {
            //  Если вернулось true.

            // То присваиваем название метода в переменную.
            $action = $this->params['action'] . 'Action';
        } else {
            // Если вернулось false.
            View::errorCode(404);
        }

        // Делаем проверку на существование метода у класса.
        if (method_exists($path, $action)) {
            // Если вернулось true.

            // Создаем объект, передаем параметры (Имя контроллера и метод). Далее вызываем метод.
            $controller = new $path($this->params);
            $controller->$action();
        } else {
            // Если вернулось false.
            View::errorCode(404);
        }
        
    }
}
