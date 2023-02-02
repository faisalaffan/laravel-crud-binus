<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{

    protected $fillable = [
        'id_barang',
        'nama_barang',
        'deskripsi',
        'jenis_barang',
        'stock_barang',
        'harga_beli',
        'harga_jual',
        'gambar_url',
    ];

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

}
