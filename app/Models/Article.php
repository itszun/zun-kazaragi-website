<?php

namespace App\Models;

use App\Casts\HTMLEntities;
use App\Contracts\ActionButton;
use App\Traits\HasActionButton;
use App\Traits\HasAuthor;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends AppModel implements ActionButton
{
    use HasFactory, HasActionButton, HasSlug, HasAuthor;
    protected $guarded = ["id"];
    protected $casts = [
        "body" => HTMLEntities::class
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $model->slug = Str::slug($model->title).'-'.Str::random(3);
            $model->author_id = $model->getAuthor();
        });
    }

    public function category() {
        return $this->belongsTo(Classification::class, 'category_id', 'id');
    }

    public function tags() {
        return $this->hasMany(Tags::class, 'thing_id');
    }

    public function getShortBodyAttribute()
    {
        return Str::of(strip_tags($this->body))->limit(120);
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
