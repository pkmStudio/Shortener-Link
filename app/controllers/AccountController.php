<?php

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller
{

   // Страница Регистрация
   public function registerAction()
   {
      //! Если форма не пустая.
      if (!empty($_POST)) {

         $result = $this->model->registerModel();
         if (isset($result['url'])) {
            $this->view->redirectAJAX($result['url']);
         } else {
            $this->view->message($result);
         }

      }

      // 'Страница регистрации.';
      $this->view->render('Регистрация');
   }

   // Страница Вход / Логинация
   public function loginAction()
   {
      //! Если форма не пустая.
      if (!empty($_POST)) {
         $result = $this->model->loginModel();

         if (isset($result['url'])) {
            $this->view->redirectAJAX($result['url']);
         } else {
            $this->view->message($result);
         }
      }

      // 'Страница входа';
      $this->view->render('Вход');

   }

   // Выход
   public function exitAction()
   {
      $result = $this->model->exitModel();
      if (isset($result['url'])) {
         $this->view->redirectAJAX($result['url']);
      } else {
         $this->view->message($result);
      }

      $this->view->render('Выход с ЛК');
   }

   // Страница Личного Кабинета
   public function lkAction ()
   {
      // 'Страница Личного Кабинета';
      $this->view->render('Личный кабинет');
   }

      // Страница Контакты
      public function contactsAction ()
      {
         //! Если форма не пустая.
         if (!empty($_POST)) {

            $result = $this->model->contactsModel();
            if (isset($result['url'])) {
               $this->view->redirectAJAX($result['url']);
            } else {
               $this->view->message($result);
            }
         }

         // 'Страница Отправки почты
         $this->view->render('Личный кабинет');
      }
}
