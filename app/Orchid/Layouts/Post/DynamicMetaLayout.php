<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Post;

use Nakukryskin\OrchidRepeaterField\Fields\Repeater;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class DynamicMetaLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('key')
                ->type('text')
                ->title(__("Key")),
            Input::make('value')
                ->type('text')
                ->title(__("Value"))

        ];
    }
}
