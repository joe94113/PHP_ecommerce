<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class LogError extends Model
{
    use HasFactory;
    use softDeletes;

    protected $guarded = [''];  // 所有欄位可更改
    protected $casts = [  // 這些屬性被處理時，會被當成甚麼資料類型
        'trace' => 'array',
        'params' => 'array',
        'header' => 'array',
    ];
}
