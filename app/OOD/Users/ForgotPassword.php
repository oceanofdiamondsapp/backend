<?php
namespace OOD\Users;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model {

	protected $fillable = [
        'email', 'key', 'bused'
    ];

}
