<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Post;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class PostMetadataLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('post.meta-title')
                ->type('text')
                ->max(255)
                ->title(__('Meta Title'))
                ->placeholder(__('Meta Title')),
            Input::make('post.slug')
                ->type('text')
                ->max(100)
                ->title(__('Slug'))
                ->placeholder(__("Slug")),
            Input::make('post.summary')
                ->title(__('Summary'))
                ->placeholder(__('Summary')),
        ];
    }
}
