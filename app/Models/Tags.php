<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function classification() {
        return $this->belongsTo(Classification::class, 'tags_id');
    }

    public function article() {
        return $this->belongsTo(Article::class, 'thing_id');
    }
}
