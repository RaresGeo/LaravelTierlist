<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function path()
    {
        return URL::to('/images') . '/' . preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $this->name);
    }
}
