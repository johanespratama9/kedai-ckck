<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_meja',
        'customer_name',
        'phone',
        'total_harga',
        'status',
        'status_makanan',
        'keterangan',
        'started_at',
        'payment_method',
        'bukti_transfer',
        'paid_at',
        'approved_at',
        'approved_by',
        'approval_status',
        'rejection_reason',
    ];

    protected $casts = [
        'started_at'  => 'datetime',
        'paid_at'     => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
