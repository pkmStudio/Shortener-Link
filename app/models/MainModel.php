<?php

namespace app\models;

use app\core\Model;

class MainModel extends Model
{

	// !Убрать к чертям, тут будет другое.
   public function getNews()
	{
		$result = $this->row('SELECT title FROM article');
		return $result;
	}
}
