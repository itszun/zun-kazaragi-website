<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use HasFactory, AsSource, Filterable, Attachable, HasSlug;
    protected $guarded = ['id'];


    public function categories() {
        return $this->belongsToMany(Category::class, 'post_categories');
    }

    public function metadatas() {
        return $this->hasMany(PostMeta::class, 'post_id', 'id');
    }

    public static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->author_id = request()->user()->id;
            $model->meta_title = $model->meta_title ?? $model->title;
            $model->summary = $model->summary ?? substr(CleanHTML($model->content), 0, 200);
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->skipGenerateWhen(fn() => $this->status == "draft");
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
