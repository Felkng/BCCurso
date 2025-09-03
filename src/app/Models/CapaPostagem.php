<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaPostagem extends Model
{
    use HasFactory;

    protected $table = 'capa_postagem';

    protected $fillable = [
        'imagem',
        'postagem_id',
    ];
    
    public function postagem(){
        return $this->belongsTo(Postagem::class);
    }
}
