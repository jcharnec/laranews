<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'tema',
        'texto',
        'imagen',
        'visitas',
        'user_id',
        'rejected',
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
     * Relación con el usuario autor
     * Si el user_id es null, devuelve "Anónimo"
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anónimo',
        ]);
    }

    /**
     * Relación con los comentarios
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->latest();
    }

    /**
     * Devuelve la URL de la imagen de la noticia (o una por defecto)
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->imagen) {
            return asset('storage/images/noticias/default.jpg');
        }

        $path = $this->imagen;

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        if (str_starts_with($path, 'images/')) {
            return asset('storage/' . $path);
        }

        return asset('storage/images/noticias/' . $path);
    }
}
