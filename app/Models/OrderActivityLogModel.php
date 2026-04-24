<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderActivityLogModel extends Model
{
    use HasFactory;

    protected $table = 'order_activity_logs';

    protected $fillable = [
        'order_id',
        'user_id',
        'action',
        'description',
        'old_value',
        'new_value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function logActivity($order_id, $action, $description = null, $old_value = null, $new_value = null)
    {
        return self::create([
            'order_id'    => $order_id,
            'user_id'     => auth()->check() ? auth()->id() : null,
            'action'      => $action,
            'description' => $description,
            'old_value'   => $old_value,
            'new_value'   => $new_value,
        ]);
    }
}
