<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tcc extends Model
{
    protected $table = 'tcc';

    protected $fillable = [
        'titulo',
        'resumo',
        'ano',
        'aluno_id',
        'banca_id',
        'arquivo_id',
        'status'
    ];

    public function aluno() {
        return $this->hasOne(Aluno::class, 'id', 'aluno_id');
    }

    public function banca() {
        return $this->hasOne(Banca::class, 'id', 'banca_id');
    }


    public function orientador() {
        return $this->belongsTo(Professor::class, 'professor_id');
    }

    public function arquivo() {
        return $this->hasOne(ArquivoTcc::class, 'id', 'arquivo_id');
    }

    public function favoritos()
    {
        return $this->morphMany(Favorito::class, 'favoritavel');
    }

    public function totalFavoritos()
    {
        return $this->favoritos()->count();
    }

    public function jaFavoritadoPor($userId)
    {
        return $this->favoritos()->where('user_id', $userId)->exists();
    }
}
