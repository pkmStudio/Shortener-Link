<?php

namespace app\models;

use app\core\Model;

class AccountModel extends Model
{
	// Модуль шифрования пароля
	public function getPassword($userPassword) {
		$salt = 'dfk65465lgF6889FJKs';
		$userPassword = md5($salt . $userPassword . $salt);
		return $userPassword;
	}

	// Модуль при ригистрации
	public function registerModel()
	{
		$userLogin = trim(filter_var($_POST['userLogin'], FILTER_SANITIZE_SPECIAL_CHARS));
		$userPassword = trim(filter_var($_POST['userPassword'], FILTER_SANITIZE_SPECIAL_CHARS));
		$userRepeatPassword = trim(filter_var($_POST['userRepeatPassword'], FILTER_SANITIZE_SPECIAL_CHARS));

		// Начинаем проверку формы
		if (empty($userLogin)) {
			// Поле Логин

			$result = ['status' => 'Error', 'message' => 'Нельзя оставлять поле "Логин" пустым'];
			return $result;

		} elseif (strlen($userLogin) < 2) {

			$result = ['status' => 'Error', 'message' => 'В поле "Логин" должно быть больше 2-х символов'];
			return $result;

		} elseif (isset($this->row("SELECT `Login` FROM `users` WHERE `Login` = :login", ['login' => $userLogin])[0]->Login)) {

			$result = ['status' => 'Error', 'message' => 'Аккаунт с таким Логином уже существует'];
			return $result;

		}

		if (empty($userPassword) || empty($userRepeatPassword)) {
			// Поле пароля

			$result = ['status' => 'Error', 'message' => 'Поля "Пароль" и "Повторить пароль" нельзя оставлять пустыми'];
			return $result;

		} elseif (strlen($userPassword) < 8) {
			
			$result = ['status' => 'Error', 'message' => 'Поле "Пароль" должно содержать 8 символов'];
			return $result;

		} elseif ($userPassword !== $userRepeatPassword) {
			
			$result = ['status' => 'Error', 'message' => 'Поля "Пароль" и "Повторить пароль" не совпадают'];
			return $result;

		}

		// Если все нормально
		$userPassword = $this->getPassword($userPassword);
		$params = ['login' => $userLogin, 'password' => $userPassword];

		$this->query("INSERT INTO `users` (`Login`, `PassWord`) VALUE (:login, :password)", $params);
		
		$result = ['status' => 'Done', 'url' => '/'];
		return $result;
	}

	// Модуль при входе / логинации
	public function loginModel()
	{
		$userLogin = trim(filter_var($_POST['userLogin'], FILTER_SANITIZE_SPECIAL_CHARS));
		$userPassword = trim(filter_var($_POST['userPassword'], FILTER_SANITIZE_SPECIAL_CHARS));

		// Начинаем проверку формы
		if (empty($userLogin)) {
			// Поле Логин

			$result = ['status' => 'Error', 'message' => 'Нельзя оставлять поле "Логин" пустым'];
			return $result;

		} elseif (strlen($userLogin) < 2) {

			$result = ['status' => 'Error', 'message' => 'В поле "Логин" должно быть больше 2-х символов'];
			return $result;

		}

		if (empty($userPassword)) {
			// Поле пароля

			$result = ['status' => 'Error', 'message' => 'Поля "Пароль" и "Повторить пароль" нельзя оставлять пустыми'];
			return $result;

		} elseif (strlen($userPassword) < 8) {
			
			$result = ['status' => 'Error', 'message' => 'Поле "Пароль" должно содержать 8 символов'];
			return $result;

		}

		// Если все нормально
		$userPassword = $this->getPassword($userPassword);

		$params = ['login' => $userLogin, 'password' => $userPassword];
		$result = $this->query("SELECT `Login` FROM `users` WHERE `Login` = :login AND `PassWord` = :password", $params);

		if ($result->rowCount() != 0) {
			setcookie('loginpreview', $userLogin, time() + 60*60*24*30, "/");
			$_SESSION['authorize']['login'] = $userLogin;
			$result = ['status' => 'Done', 'url' => '/account'];
			return $result;
		}
		
		// $result = ['status' => 'Done', 'url' => '/account/lk'];
		// return $result;
	}

	// Модуль при выходе из Личного Кабинета
	public function exitModel()
	{
		setcookie('loginpreview', '', time() - 60*60*24*365, "/");
      unset($_COOKIE['loginpreview']);
		unset($_SESSION['authorize']); 
		session_destroy();

		$result = ['status' => 'Done', 'url' => '/account/login'];
		return $result;
	}

   public function contactsModel()
   {
		$userEmail = trim(filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL));
		$userTheme = trim(filter_var($_POST['userTheme'], FILTER_SANITIZE_SPECIAL_CHARS));
		$userText = trim(filter_var($_POST['userText'], FILTER_SANITIZE_SPECIAL_CHARS));
		
		// Начинаем проверку формы
		if (empty($userEmail)) {
			// Поле Логин

			$result = ['status' => 'Error', 'message' => 'Нельзя оставлять поле "Email" пустым'];
			return $result;

		} elseif (strlen($userEmail) < 5) {

			$result = ['status' => 'Error', 'message' => 'В поле "Email" должно быть больше 5-ти символов'];
			return $result;

		}

		if (empty($userTheme) || empty($userText)) {
			// Поле пароля

			$result = ['status' => 'Error', 'message' => 'Поля "Theme" и "Message" нельзя оставлять пустыми'];
			return $result;

		} elseif (strlen($userText) < 15) {
			
			$result = ['status' => 'Error', 'message' => 'Поле "Message" должно содержать от 15 символов'];
			return $result;

		}
	}
}
