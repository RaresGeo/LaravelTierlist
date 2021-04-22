<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'colour',
    ];

    public function getColour()
    {
        return preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $this->colour);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
