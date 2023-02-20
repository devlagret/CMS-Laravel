<?php

namespace App\Helpers;

use App\Models\Permision;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
function getrole(){return 'pah';}
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
				$user_id = Token::where('token', '=', $token)->first();
				$r = mysqli_fetch_object(mysqli_query(mysqli_connect("localhost", env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge')), 'select user_id, username, name, role_id, created_at, updated_at from user where user_id = "' . $user_id->user_id . '" limit 1'));
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
					exit();
				}
				return $r;
			case 'user_id':
				$user_id = Token::where('token', '=', $token)->first();
				return $user_id->user_id;
			case 'name':
				$user_id = Token::where('token', '=', $token)->first();
				$usr = User::where('id', $user_id->user_id)->first();
				return $usr->name;
			case 'username':
				$user_id = Token::where('token', '=', $token)->first();
				$usr = User::where('id', $user_id->user_id)->first();
				return $usr->username;
			default:
				echo 'Unavaible Option';
				break;
		}
	}
	public function getAllUser()
	{
		$r = array();
		$d = mysqli_fetch_all(mysqli_query(mysqli_connect("localhost", env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge')), 'select user_id, username, name, role_id, created_at, updated_at from user'), MYSQLI_ASSOC);
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}
		return $d;
	}
	/**
	 * get user by id
	 * @param mixed $id
	 * @return bool|null|object
	 */
	public function getUserByid($id)
	{
		$r = mysqli_fetch_object(mysqli_query(mysqli_connect("localhost", env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge')), 'select user_id, username, name, role_id, created_at, updated_at from user where user_id = "' . $id . '" limit 1'));
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}
		return $r;
	}
	/**
	 * Get usesr's role
	 * @param mixed $token
	 * @return mixed
	 */
	public function getRole($token = null)
	{
		$user_id = Token::where('token', '=', $token)->first();
		if ($token == null) {
			$user_id = Auth::user();}
		$usr = User::where('user_id', $user_id->user_id)->first();
		$role = Role::where('role_id', $usr->role_id)->first();
		return $role->name;
	}
	/**
	 * Check if given user (id) have the given permision
	 * @param string $user_id
	 * @param array $permision
	 * @return bool true if at least 1 given permision found
	 */
	public function checkPermision(String $user_id,Array $permision ){
		$privilege = Privilege::where('role_id', User::find($user_id)->role_id)->get('permision_id');
		$permision = Permision::whereIn('permision_id', $privilege)->whereIn('name', $permision)->exists();
		return $permision;
	}
	/**
	 * Get where user assigned
	 * @return string ('branch','warehouse','company')
*/
	public function getPosition($id = null)
	{
		if($id==null){
		$usr = User::find(Auth::id());
	}else{
		$usr = User::find($id);
	}
		if($usr->branch != null){
			return "branch";
		} elseif ($usr->warehouse != null) {
			return "warehouse";
		} elseif ($this->checkPermision($usr->user_id,['super-admin'])){
			return "admin";
		}return "company";
	}
}
