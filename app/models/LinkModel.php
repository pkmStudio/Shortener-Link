<?php

namespace app\models;

use app\core\Model;

class LinkModel extends Model
{
	// Модуль добавление ссылки в БД
	public function addModel()
	{
		$longLink = trim(filter_var($_POST['longLink'], FILTER_SANITIZE_URL));
		$shortLink = trim(filter_var($_POST['shortLink'], FILTER_SANITIZE_SPECIAL_CHARS));


		// Начинаем проверку формы
		if (empty($longLink) || empty($shortLink)) {
			// Поле сокращения

			$result = ['status' => 'Error', 'message' => 'Нельзя оставлять поля пустыми'];
			return $result;

		} elseif (strlen($longLink) > 250 || strlen($shortLink) > 250) {

			$result = ['status' => 'Error', 'message' => 'Очень длинные ссылки'];
			return $result;

		} elseif (!preg_match('#^(https?:\/\/)?([\w-]{1,32}\.[\w-]{1,32})[^\s@]*$#', $longLink, $matches)) {

			$result = ['status' => 'Error', 'message' => 'Введите корректную ссылку на сайт'];
			return $result;

		}elseif ($this->column("SELECT `short_link` FROM `link` WHERE `short_link` = :shortLink", ['shortLink' => $shortLink])) {

			$result = ['status' => 'Error', 'message' => 'Ccылка с таким сокращением уже существует'];
			return $result;

		}


		// Если все нормально
		$userLogin = $_SESSION['authorize']['login'];
		$params = ['user_login' => $userLogin, 'short_link' => $shortLink, 'long_link' => $longLink];

		$insert = $this->query("INSERT INTO `link` (`user_login`, `short_link`, `long_link`) VALUE (:user_login, :short_link, :long_link)", $params);
		
		if ($insert->rowCount() != 0) {
			$result = ['status' => 'Done', 'url' => '/'];
			return $result;
		} else {
			$result = ['status' => 'Error', 'message' => 'Ccылка по каким-то причинам не была добавлена'];
			return $result;
		}
	}

	// Модуль отображения сокращенных ссылок
	public function viewModel()
	{
		$userLogin = $_SESSION['authorize']['login'];
		$params = ['user_login' => $userLogin];

		$result = $this->row("SELECT `long_link`, `short_link` FROM `link` WHERE `user_login` = :user_login", $params);

		return $result;
	}

		// Модуль отображения сокращенных ссылок
		public function deleteModel()
		{
			$postData = file_get_contents('php://input');
			$data = json_decode($postData, true);
			$shortLink = $data['short_link'];
			$shortLink = trim(filter_var($shortLink, FILTER_SANITIZE_SPECIAL_CHARS));
			$params = ['short_link' => $shortLink];
	
			$delete = $this->query("DELETE  FROM `link` WHERE `short_link` = :short_link", $params);
	
			if ($delete->rowCount() != 0) {
				$result = ['status' => 'Done', 'url' => '/'];
				return $result;
			} else {
				$result = ['status' => 'Error', 'message' => 'Ccылка по каким-то причинам не была удалена'];
				return $result;
			}
		}
	
		// Модуль перевода с сокращенной на обычную ссылку
		public function relocationModel($shortLink)
		{
			$shortLink = trim(filter_var($shortLink, FILTER_SANITIZE_SPECIAL_CHARS));
			$params = ['short_link' => $shortLink];

			$result = $this->column("SELECT `long_link` FROM `link` WHERE `short_link` = :short_link", $params);
			return $result;
		}
}
