<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['link', 'curriculo_professor_id'];

    public function curriculoProfessor()
    {
        return $this->belongsTo(CurriculoProfessor::class);
    }
}
