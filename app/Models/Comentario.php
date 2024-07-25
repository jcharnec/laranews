<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = ['texto', 'user_id', 'noticia_id'];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of noticia
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }
}
