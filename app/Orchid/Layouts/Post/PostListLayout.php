<?php

namespace App\Orchid\Layouts\Post;

use App\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('title', __('Title'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn(Post $post) => $post->title),
            TD::make('summary', __("Summary"))
                ->render(fn(Post $post) => $post->summary),
            TD::make('created_at', __("Created At"))
                ->sort()
                ->render(fn(Post $post) => $post->created_at->toDateTimeString()),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Post $post) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.systems.posts.edit', $post->slug)
                            ->icon('pencil'),
                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the Post is deleted, it will be permanently deleted. Put in to Draft if you want to unpublished this post'))
                            ->method('remove', [
                                'slug' => $post->slug
                            ])
                    ])
                )
        ];
    }
}
