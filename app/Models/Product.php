<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\NotDeletedScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'quantity',
        'image_path',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }

        if (Str::startsWith($this->image_path, 'https://')) {
            return $this->image_path;
        }

        $fileContents = Storage::disk('ftp')->get($this->image_path);
        return 'data:image/jpeg;base64,' . base64_encode($fileContents);
    }
}
