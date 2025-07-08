<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope('sort', function ($builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
}
