<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tierlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rows()
    {
        return $this->hasMany(Row::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class)->orderByDesc('score');
    }
}
