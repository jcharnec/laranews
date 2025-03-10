<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'titulo', 'tema',
        'texto', 'imagen', 'visitas',
        'user_id', 'rejected'
    ];

    /**
     * Summary of recent
     * @param int $number
     * @return Noticia[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function recent(int $number = 1)
    {
        return self::whereNotNull('imagen')
            ->latest()
            ->limit($number)
            ->get();
    }

    /**
     * Summary of user
     * retorna el usuario propietario de la noticia
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of comentarios
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
