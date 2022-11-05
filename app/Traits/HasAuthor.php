<?php
namespace App\Traits;

use App\Models\User;

trait HasAuthor {
    public function author() {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function getAuthor() {
        return $this->author_id ?? request()->user()->id;
    }
}
