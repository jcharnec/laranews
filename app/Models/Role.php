<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Role.php
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role'];

    // Nombres canónicos
    public const INVITADO       = 'invitado';
    public const LECTOR         = 'lector';
    public const REDACTOR       = 'redactor';
    public const EDITOR         = 'editor';
    public const ADMINISTRADOR  = 'administrador';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
