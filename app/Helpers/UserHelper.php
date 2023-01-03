<?php

namespace App\Helpers;

class UserHelper
{

	public static function sayhello()
	{
		return "Hello Friends";
	}

	public function getUserData($id){
		$r = mysqli_fetch_assoc(mysqli_query(mysqli_connect("localhost", env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge')), 'select id, username, name, role, created_at, updated_at from users where id = '.$id.' limit 1'));
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}
		return $r;
	}
}
