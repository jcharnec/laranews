<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   // ⬅️ importa el trait
use Illuminate\Support\Str;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;                // ⬅️ actívalo aquí

    protected $fillable = [
        'titulo',
        'tema',
        'texto',
        'imagen',
        'visitas',
        'user_id',
        'rejected'
    ];

    /**
     * Devuelve las noticias recientes
     */
    public static function recent(int $number = 1)
    {
        return self::whereNotNull('imagen')
            ->latest()
            ->limit($number)
            ->get();
    }

    /**
     * Relación con usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con comentarios
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->latest();
    }

    /**
     * Accessor para obtener la URL de la imagen
     */
    public function getImageUrlAttribute()
    {
        if (!$this->imagen) {
            return asset('storage/images/noticias/default.jpg');
        }

        // Si viene con carpeta incluida (casos antiguos)
        if (Str::startsWith($this->imagen, ['images/', 'public/'])) {
            return asset('storage/' . ltrim($this->imagen, 'public/'));
        }

        // Si solo es el nombre del archivo
        return asset('storage/images/noticias/' . $this->imagen);
    }
}
