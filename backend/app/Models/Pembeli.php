<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{

    protected $fillable = [
        'ttl',
        'jenis_kelamin',
        'alamat',
        'ktp_url',
        'id_user',
    ];

    protected $table = 'pembeli';
    protected $primaryKey = 'id_pembeli';
    public $timestamps = false;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

}
