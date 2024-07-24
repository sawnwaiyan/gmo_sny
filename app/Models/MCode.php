<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCode extends Model
{
    use HasFactory;

    protected $table = 'm_codes';

    protected $fillable = [
        'pa_cd', 'ch_cd', 'pa_name', 'ch_name', 'sort_order', 'is_deleted', 'created_by', 'updated_by'
    ];
}
