<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends AdminController
{
    public function _setPageInfo() {
        PageInfo()->setInfo(
            "Artikel",
            "Posting Artikel ke Halaman",
            "",
            [
                'datatable_headers' => json_encode([
                    '#No'=> 'no',
                    'Title' => 'title',
                    'Body' => 'body',
                    '#' => 'action'
                ]),
                'datatable_url' => route('admin.article.list'),
            ]
        );
    }

    public function index()
    {
        return view('admin.article.index');
    }

    public function list(Request $request)
    {

        $keyword = $request->keyword ? "%$request->keyword%" : null;
        $columns = $request->columns;
        $order_by = $columns[$request->order[0]['column']]['data'];
        $order_dir = $request->order[0]['dir'];

        // Subquery For Product - Showroom
        $filtered = $count = Article::count();

        $query = Article::query();

        $query = $query->orderBy($order_by, $order_dir)->offset($request->start)->limit($request->length);

        $no = $request->start;
        $sql = $query->toSql();

        $result = $query->get();
        $result = $result->map(function($item) use (&$no) {
            $no = $no + 1;
            return collect($item)
                ->put('title', empty($item->title) ? "(No Title)" : $item->title )
                ->put('body', $no)
                ->put('no', $no)
                ->put('body', $item->short_body)
                ->put('action', $item->actionButton);
        })->toArray();

        $table = [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $filtered,
            'data' => $result,
            // 'sql' => $sql
        ];

        return response()->json($table);
    }

    public function form(Article $article)
    {
        return view('admin.article.form', compact('article'));
    }

    public function save(Request $request, $article)
    {
        $article = $article == "create" ? new Article() : Article::findOrFail($article);
        $validated = $request->validate([
            "parent_id" => "nullable",
            "title" => "nullable|string|max:50",
            "body" => "nullable|string",
        ]);

        $article->updateOrCreate(['id' => $article->id], $validated);

        if (!$request->expectsJson()) {
            return redirect()->route('admin.article.edit', $article->id);
        }
        return APIResponse("success", "Article Berhasil Disimpan", [
            "message" => "Article Berhasil Disimpan",
            "redirectUrl" => route('admin.article.edit', $article->id)
        ]);
    }

    public function destroy(Article $article, Request $request)
    {
        $article->delete();

        if (!$request->expectsJson()) {
            return redirect('admin.article.index');
        }
        return APIResponse("success", "Article Berhasil Dihapus");
    }
}
