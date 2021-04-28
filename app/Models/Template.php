<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'formula',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->hasOne(Image::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function rows()
    {
        return $this->hasMany(Row::class);
    }
}
