<?php

namespace App\Services;

use App\Models\User;
use Hash;

class UserService{

	public static function create($name,$email,$password,$role){

		$user = new User();
		$user->name = $name;
		$user->email = $email;
		$user->password = Hash::make($password);
		$user->role = $role;
		$user->save();

		return $user;
	}
}
?>