<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'id_user',
    ];

    protected $table = 'staff';
    protected $primaryKey = 'id_staff';
    public $timestamps = false;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

}
