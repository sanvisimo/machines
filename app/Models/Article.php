<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function managedArticles()
    {
        return $this->hasMany(ManagedArticle::class);
    }

    public function getName() {
        return $this->reference .' - '.$this->article->drawing;
    }
}
