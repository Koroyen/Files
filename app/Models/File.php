<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{

    use HasFactory;
protected $fillable = [
    'user_id',
    'type',
    'document_number',
    'title',
    'remarks',
    'file_name',
    'file_path',
    'updated_by',
    'is_deleted',
    'uuid',
];
public function uploader()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

public function updater()
{
    return $this->belongsTo(\App\Models\User::class, 'updated_by');
}

protected static function boot()
{
    parent::boot();

    static::creating(function ($file) {
        $file->uuid = Str::uuid();
    });
}

}
