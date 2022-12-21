<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Post;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class PostEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('post.title')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Title'))
                ->placeholder(__('Title')),
            Quill::make('post.content')
                ->required()
                ->title(__('Content'))
                ->placeholder(__('Content')),

        ];
    }
}
