<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postagem extends Model {

    protected $table = 'postagem';
    
    protected $fillable = [
        'titulo',
        'texto',
        'tipo_postagem_id',
        'menu_inicial',
    ];

    public function imagens(){
        return $this->hasMany(ImagemPostagem::class);
    }

    public function capa(){
        return $this->hasOne(CapaPostagem::class);
    }

    public function arquivos(){
        return $this->hasMany(ArquivoPostagem::class);
    }

    public function isPinned(){
      return PinnedPosts::where('postagem_id', $this->id)->exists();
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->orderBy('created_at', 'asc');
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


    public static function checkMainImageSize($imagem)
    {
        $dimensions = getimagesize($imagem);
        if ($dimensions === false) {
            return false;
        }

        $largura = $dimensions[0];
        $altura = $dimensions[1];

        return $largura === 2700 && $altura === 660;
    }
}
