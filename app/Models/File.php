<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * @method static where(string $string, mixed $order_id)
 */
class File extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'access_token',
        'file_name',
        'file_path',
        'file_type',
    ];

    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        // 'user_id' => 'encrypted',
        // 'order_id' => 'encrypted',
        // 'access_token' => 'encrypted',
        'file_name' => 'encrypted',
        'file_path' => 'encrypted',
//        'file_type' => 'encrypted',
    ];
}
