<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    public static function getTags() {
        return self::where('kind', 'tags')->get();
    }

    public static function getCategories() {
        return self::where('kind', 'categories')->get();
    }

    public static function getRoles() {
        return self::where('kind', 'roles')->get();
    }
}
