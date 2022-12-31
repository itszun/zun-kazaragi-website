<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Post;

use App\Models\Category;
use App\Models\Tag;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class PostTagsLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Relation::make('post_tags.')
                ->type('select')
                ->fromModel(Tag::class, 'title')
                ->title(__('Tags'))
                ->empty("No Tags")
                ->multiple(),
            Relation::make('post_categoris')
                ->title(__('Categories'))
                ->fromModel(Category::class, 'title')
                ->empty('No Categories')
        ];
    }
}
