<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Orchid\Layouts\Post\DynamicMetaLayout;
use App\Orchid\Layouts\Post\PostEditLayout;
use App\Orchid\Layouts\Post\PostMetadataLayout;
use App\Orchid\Layouts\Post\PostTagsLayout;
use Illuminate\Http\Request;
use Nakukryskin\OrchidRepeaterField\Fields\Repeater;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    /**
     * @var Post
     */
    public $post;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Post $post): iterable
    {
        return [
            'post' => $post,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->post->exists ? 'Edit Post' : 'Create Post';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__("Draft"))
            ->icon('doc')
            ->method('draft'),
            Button::make(__("Publish"))
                ->icon('share-alt')
                ->method('publish'),
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
            Layout::accordion([
                "Tags" => PostTagsLayout::class,
                "Metadata" => Layout::columns([
                    PostMetadataLayout::class,
                    Layout::rows([
                        Repeater::make('post_metas')
                            ->title('Meta')
                            ->layout(DynamicMetaLayout::class)
                            ->min(1)
                            ->buttonLabel(__("Add Meta Description"))
                    ])
                ])
            ]),
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
        if ($post->exists) {
            return redirect()->route('platform.systems.posts.edit', $post->slug);
        }
        return redirect(url()->current());
    }

    /**
     * Publish Post
     *
     * @param Request $request
     * @return void
     */
    public function draft(Post $post, Request $request)
    {
        $request->validate([
            'post.title' => ['required'],
            'post.content' => ['required']
        ]);

        $post
            ->fill($request->collect('post')->toArray())
            ->fill(['status' => 'draft', 'published_at' => null])
            ->save();

        Toast::info(__('Post drafted.'));
        if ($post->exists) {
            return redirect()->route('platform.systems.posts.edit', $post->slug);
        }
        return redirect(url()->current());
    }
}
