<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMCode extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'm_codes';

    protected $fillable = [
        'pa_cd', 'ch_cd', 'pa_name', 'ch_name', 'sort_order', 'is_deleted', 'created_by', 'updated_by'
    ];
}
