<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Orchid\Layouts\Post\PostEditLayout;
use App\Orchid\Layouts\Post\PostMetadataLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Post Edit';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__("Publish"))
                ->icon('share-alt')
                ->method('publish')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            PostEditLayout::class,
            PostMetadataLayout::class
        ];
    }

    /**
     * Publish Post
     *
     * @param Request $request
     * @return void
     */
    public function publish(Post $post, Request $request)
    {
        $request->validate([
            'post.title' => ['required'],
            'post.content' => ['required']
        ]);

        $post
            ->fill($request->collect('post')->toArray())
            ->fill(['status' => 'published', 'published_at' => now()])
            ->save();

        Toast::info(__('Post published.'));
        return redirect(url()->current());
    }
}
