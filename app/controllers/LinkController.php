<?php

namespace app\controllers;

use app\core\Controller;

class LinkController extends Controller
{
   // ?Попробовать поменять какое-то сообщение на $this->view->errorCode();
   // Метод, который создает ссылку в БД
   public function addAction()
   {
      //! Если форма не пустая.
      if (!empty($_POST)) {

         $result = $this->model->addModel();
         if (isset($result['url'])) {
            $this->view->redirectAJAX($result['url']);
         } else {
            $this->view->message($result);
         }

      }
   }


   // Метод, который показываает сокращенные ссылки пользователя
   public function viewAction()
   {
      // Запрашиваем сокращенные ссылки
      $result = $this->model->viewModel();

      // Возвращаем результат на главную стр.
      return $result;
   }


   // Метод, который удаляет ссылки из БД
   public function deleteAction()
   {
      // Запрашиваем удаление
      $result = $this->model->deleteModel();
      if (isset($result['url'])) {
         $this->view->redirectAJAX($result['url']);
      } else {
         $this->view->message($result);
      }

   }

   public function relocationAction()
   {
      $link = $this->route['link'];
      $url = $this->model->relocationModel($link);
      if (isset($url)) {
         $this->view->redirectServer($url);
      } else {
         $this->view->errorCode(404);
      }
   }
}
