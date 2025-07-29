<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'nomor_meja',
        'qr_code_path',
    ];
}
