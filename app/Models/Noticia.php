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
     * Obtiene la URL de la imagen de la noticia.
     * Si no hay imagen, devuelve una por defecto.
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->imagen) {
            return asset('storage/images/noticias/default.jpg');
        }
        $path = $this->imagen;
        if (\Illuminate\Support\Str::startsWith($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }
        if (\Illuminate\Support\Str::startsWith($path, 'images/')) {
            return asset('storage/' . $path);
        }
        return asset('storage/images/noticias/' . $path);
    }
}
