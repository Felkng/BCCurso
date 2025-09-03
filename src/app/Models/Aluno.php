<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'aluno';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'matricula',
        'user_id',
        'email',
    ];

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'alunos_projetos', 'aluno_id', 'projeto_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    public function declaracoesIntencaoMatricula()
    {
        return $this->hasMany(DeclaracaoIntencaoMatricula::class, 'aluno_id');
    }
}
