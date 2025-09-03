<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function fotos(){
        return $this->hasMany(FotoUser::class);
    }
    
  

    public function servidor(){
        return $this->hasOne(Servidor::class);
    }

    public function aluno(){
        return $this->hasOne(Aluno::class);
    }
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function postagensFavoritas()
    {
        return $this->favoritos()->where('favoritavel_type', Postagem::class)
            ->with('favoritavel');
    }

    public function tccsFavoritos()
    {
        return $this->favoritos()->where('favoritavel_type', Tcc::class)
            ->with('favoritavel');
    }

    public function jaFavoritou($modelo)
    {
        return $this->favoritos()
            ->where('favoritavel_type', get_class($modelo))
            ->where('favoritavel_id', $modelo->id)
            ->exists();
    }
}
