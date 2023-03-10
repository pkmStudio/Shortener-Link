<?php
// Батя всех контроллеров, здесь описан основной функционал взаимодействия пользователя с сайтом. 

namespace app\core;

use app\core\View;

abstract class Controller
{
    public $route;
    public $acl;
    public $view;
    public $model;

    public function __construct($route) {
        // Записываем маршрут от страницы, на которой сидим. 
        $this->route = $route;

        // Если нет доступа то выводим ошибку 403.
        if (!$this->checkAcl()) {$this->view->errorCode(403);}
        
        //Создаем объект на основе класса View и передаем информацию, о том что нам отобразить в класс View
        $this->view = new View($route);
        // Создаем объект модели, если такая есть. 
        $this->model = $this->loadModel($route['controller']);
    }

    // Эта функция загружает нужную модель по имени контроллера.
    public function loadModel($name)
    {
        $path = ucfirst($name);
        $path = "app\models\\{$path}Model";

        // Проверяем на наличие класса модели с таким именем.
        if (class_exists($path)) {
            // Если вернулось true - создаем объект.
            return new $path;
        } 
        else {
            // Если вернулось false.
            $this->view->errorCode(404);
        }
    }

    // Проверяет на права доступа к старнице. Этакий КОНТРОЛЬ ДОСТУПА.
    public function checkAcl()
    {
        // Находим путь к файлу 
		$this->acl = require 'app/acl/'.$this->route['controller'] . '.php';

        // Делаем проверку, если страница для всех, тогда true.
		if ($this->isAcl('all')) {
			return true;
		}
        // Делаем проверку, если страница для авторизованных и есть авторизация.
        elseif (isset($_SESSION['authorize']['login']) and $this->isAcl('authorize')) {
			return true;
		}
        // Делаем проверку, если страница для гостей и нет авторизации.
		elseif (!isset($_SESSION['authorize']['login']) and $this->isAcl('guest')) {
			return true;
		}
        // Делаем проверку, если страница для админа и сессия админ.
		elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
			return true;
		}
		return false;
	}

	public function isAcl($key)
    {
		return in_array($this->route['action'], $this->acl[$key]);
	}

}
