<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'score',
        'tierlist_id',
        'image_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
