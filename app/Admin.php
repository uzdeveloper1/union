<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Admin extends \TCG\Voyager\Models\User
{
    use Notifiable;
    protected $guard = 'admin';
    protected $hidden = [
        'password', 'remember_token',
    ];
}
