<?php

namespace App\Models;

use App\Contracts\ActionButton;
use App\Traits\HasActionButton;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model implements ActionButton
{
    use HasFactory, HasActionButton, HasSlug;
    protected $guarded = ["id"];

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $model->slug = Str::slug($model->title).'-'.Str::random(3);
        });
    }

    public function getShortBodyAttribute()
    {
        return Str::of($this->body)->limit(100);
    }

    public function actionButtonOptions(): array {
        return [
            'edit' => [
                'icon' => 'fa fa-eye',
                'url' => route('admin.article.edit', $this->id),
            ],
            'hapus' => [
                'icon' => 'fa fa-trash',
                'url' =>  route('admin.article.destroy', $this->id),
            ],
        ];
    }
}
