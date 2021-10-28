<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagedArticle extends Model
{
    use HasFactory;

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
