<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyPage extends Model
{
    protected $fillable = ['slug', 'locale', 'content'];

    protected function casts(): array
    {
        return ['content' => 'array'];
    }
}
