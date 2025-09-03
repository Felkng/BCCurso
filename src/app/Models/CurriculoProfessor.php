<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculoProfessor extends Model
{
    protected $table = 'curriculo_professor';
    
    protected $fillable = [
        'curriculo',
        'professor_id',
    ];

    public function links(){
        return $this->hasMany(Link::class);
    }
    public function professor(){
        return $this->belongsTo(Professor::class);
    }
}
