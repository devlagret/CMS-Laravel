<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Tokens;

class UserHelper
{
	/**
	 * Get the user data
	 * @param mixed $token
	 * @param mixed $option
	 * Avaible Option : id, name, username
	 * @return mixed
	 */
	public function getUserData($token, $option = null)
	{
		switch ($option) {
			case null:
				$uid = Tokens::where('token', '=', $token)->first();
				$r = mysqli_fetch_object(mysqli_query(mysqli_connect("localhost", env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge')), 'select uid, username, name, role, created_at, updated_at from User where uid = "' . $uid->uid . '" limit 1'));
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
					exit();
				}
				return $r;
			case 'uid':
				$uid = Tokens::where('token', '=', $token)->first();
				return $uid->uid;
			case 'name':
				$uid = Tokens::where('token', '=', $token)->first();
				$usr = User::where('id', $uid->uid)->first();
				return $usr->name;
			case 'username':
				$uid = Tokens::where('token', '=', $token)->first();
				$usr = User::where('id', $uid->uid)->first();
				return $usr->username;
			default:
				echo 'Unavaible Option';
				break;
		}
	}
	public function getAllUser()
	{
		$r = array();
		$d = mysqli_fetch_all(mysqli_query(mysqli_connect("localhost", env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge')), 'select uid, username, name, role, created_at, updated_at from User'), MYSQLI_ASSOC);
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}
		return $d;
	}
	public function getUserByid($id)
	{
		$r = mysqli_fetch_object(mysqli_query(mysqli_connect("localhost", env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge')), 'select uid, username, name, role, created_at, updated_at from User where uid = "' . $id . '" limit 1'));
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}
		return $r;
	}
	public function getRole($token)
	{
		$uid = Tokens::where('token', '=', $token)->first();
		$usr = User::where('uid', $uid->uid)->first();
		return $usr->role;
	}
}
