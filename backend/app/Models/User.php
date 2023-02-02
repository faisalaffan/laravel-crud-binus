<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'id_user',
        'nama_lengkap',
        'email',
        'password',
        'rbac',
    ];

    protected $hidden = [
        'password'
    ];

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

}
