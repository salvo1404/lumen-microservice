<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Player
 *
 * @package App\Models
 *
 * @property-read   int     $id
 * @property        string  $name
 * @property        string  $role
 * @property        string  $email
 */
class Player extends Model
{

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'role', 'email'
	];

}

