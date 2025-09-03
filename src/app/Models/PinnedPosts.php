<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinnedPosts extends Model
{

  protected $table = 'pinned_posts';

  public $incrementing = false;
  protected $primaryKey = 'postagem_id';


  protected $fillable = [
    'postagem_id',
  ];

  public function getPost()
  {
    return $this->belongsTo(Postagem::class, 'postagem_id', 'id');
  }
}
