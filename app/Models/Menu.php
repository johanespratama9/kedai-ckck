<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'stok',
        'keterangan',
        'status',
        'foto',
    ];
}
