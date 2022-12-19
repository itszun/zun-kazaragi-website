<?php

namespace App\Orchid\Layouts\Post;

use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PostFiltersLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [];
    }
}
