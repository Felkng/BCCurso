<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'conteudo',
        'postagem_id',
        'user_id',
        'editado_em'
    ];

    protected $casts = [
        'editado_em' => 'datetime',
    ];

    public function postagem()
    {
        return $this->belongsTo(Postagem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foiEditado()
    {
        return !is_null($this->editado_em);
    }
}
