<?php

namespace app\controllers;

use app\core\Controller;
use app\controllers\LinkController;

class MainController extends Controller
{
   private $vars = [];

   public function indexAction()
   {
      // Если авторизован, то создаем объект класса LinkController и вызываем отображение ссылок
      if (isset($_SESSION['authorize']['login'])) {
         $route = [
            'controller' => 'link',
            'action' => 'view',
         ];
         $linkController = new LinkController($route);
         $result = $linkController->viewAction();
         $this->vars = [
            'links' => $result,
         ];
      } else {
      $result = $this->model->getNews();
      $vars = [
         'articles' => $result,
      ];
      }
      // Вызываем метод отображения html страницы
      $this->view->render('Главная страница', $this->vars);
   }

   // !НЕ СДЕЛАЛ ЕЩЕ
   public function aboutAction()
   {
      $this->view->render('Страница с Контактами');

   }
}
