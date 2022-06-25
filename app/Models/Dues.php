<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dues extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'duesses';

    protected $fillable = [
        'year',
        'month',
        'status',
        'user_id',
        'paid_at',
        'approved_at',
        'approved_by',
        'dues_type_id',
    ];
}
