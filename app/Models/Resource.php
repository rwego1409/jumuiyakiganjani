<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = ['jumuiya_id', 'title', 'description', 'file_path', 'type', 'created_by', 'original_filename', 'file_size', 'file_extension'];

    public function jumuiya()
    {
        return $this->belongsTo(Jumuiya::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}