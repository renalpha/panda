<?php

namespace App\Models;

use Cog\Contracts\Love\Liker\Models\Liker as LikerContract;
use Cog\Laravel\Love\Liker\Models\Traits\Liker;
use Domain\Entities\PandaUser\PandaUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail, LikerContract
{
    use Notifiable, HasRolesTrait, PandaUserTrait, Liker;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
