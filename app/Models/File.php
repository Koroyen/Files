<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

protected $fillable = [
    'sender_id',
    'type',
    'document_number',
    'title',
    'remarks',
    'file_name',
    'file_path',
    'updated_by',
    'is_deleted',
];
public function uploader()
{
    return $this->belongsTo(\App\Models\User::class, 'sender_id');
}

public function updater()
{
    return $this->belongsTo(\App\Models\User::class, 'updated_by');
}

}
