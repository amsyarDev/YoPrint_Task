<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileImport extends Model
{
    protected $fillable = [
        'file_name',
        'status',
        'started_at',
        'completed_at',
    ];
}
