<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komplain extends Model
{
    protected $table = 'komplain';

    protected $fillable = [

        'pesanan_id',
        'produk_id',
        'alasan',
        'foto',
        'status'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI PESANAN
    |--------------------------------------------------------------------------
    */

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'pesanan_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PRODUK
    |--------------------------------------------------------------------------
    */

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'produk_id'
        );
    }
}