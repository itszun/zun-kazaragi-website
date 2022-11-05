<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classification;
use Illuminate\Http\Request;

class ClassificationController extends AdminController
{
    public function _setPageInfo() {
        PageInfo()->setInfo(
            "Klasifikasi",
            "Daftar istilah untuk klasifikasi data",
            "",
            [
                'datatable_headers' => json_encode([
                    '#No'=> 'no',
                    'Title' => 'title',
                    'Body' => 'body',
                    '#' => 'action'
                ]),
                'datatable_url' => route('admin.classification.list'),
            ]
        );
    }

    public function index()
    {
        return view('admin.classification.index');
    }

    public function list(Request $request)
    {

        $keyword = $request->keyword ? "%$request->keyword%" : null;
        $columns = $request->columns;
        $order_by = $columns[$request->order[0]['column']]['data'];
        $order_dir = $request->order[0]['dir'];

        // Subquery For Product - Showroom
        $filtered = $count = Classification::count();

        $query = Classification::query();

        $query = $query->orderBy($order_by, $order_dir)->offset($request->start)->limit($request->length);

        $no = $request->start;
        if ($keyword) {
            $query->where('title', 'like', $keyword);
        }
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

    public function form(Classification $classification)
    {
        return view('admin.classification.form', compact('classification'));
    }

    public function save(Request $request, $classification)
    {
        $classification = $classification == "create" ? new Classification() : Classification::idSlug($classification)->firstOrFail();
        $validated = $request->validate([
            "parent_id" => "nullable",
            "title" => "nullable|string|max:100",
            "body" => "nullable|string",
        ]);

        $classification->updateOrCreate(['slug' => $classification->slug], $validated);

        if (!$request->expectsJson()) {
            return redirect()->route('admin.classification.edit', $classification->id);
        }
        return APIResponse("success", "Classification Berhasil Disimpan", [
            "message" => "Classification Berhasil Disimpan",
            "redirectUrl" => route('admin.classification.edit', $classification->id)
        ]);
    }

    public function destroy(Classification $classification, Request $request)
    {
        $classification->delete();

        if (!$request->expectsJson()) {
            return redirect('admin.classification.index');
        }
        return APIResponse("success", "Classification Berhasil Dihapus");
    }
}
