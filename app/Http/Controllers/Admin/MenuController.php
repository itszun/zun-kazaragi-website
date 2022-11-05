<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends AdminController
{
    public function _setPageInfo() {
        PageInfo()->setInfo(
            "Menu",
            "Atur Menu yang ditampilkan di halaman Dashboard",
            "",
            [
                'datatable_headers' => json_encode([
                    '#No'=> 'no',
                    'Title' => 'title_with_parent',
                    'Icon' => 'icon',
                    'URL' => 'url',
                    'Section' => 'section',
                    '#' => 'action'
                ]),
                'datatable_url' => route('admin.menu.list'),
            ]
        );
        PageInfo()->form = [
            "parent_id_options" => Menu::getOptions()
        ];
    }

    public function index()
    {
        return view('admin.menu.index');
    }

    public function list(Request $request)
    {

        $keyword = $request->keyword ? "%$request->keyword%" : null;
        $columns = $request->columns;
        $order_by = $columns[$request->order[0]['column']]['data'];
        $order_dir = $request->order[0]['dir'];

        // Subquery For Product - Showroom
        $filtered = $count = Menu::count();

        $query = Menu::query();

        $query = $query->orderBy($order_by, $order_dir)->offset($request->start)->limit($request->length);

        $no = $request->start;
        $sql = $query->toSql();

        $result = $query->get();
        $result = $result->map(function($item) use (&$no) {
            $no = $no + 1;
            return collect($item)
                ->put('no', $no)
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

    public function form(Menu $menu)
    {
        return view('admin.menu.form', compact('menu'));
    }

    public function save(Request $request, $menu)
    {
        $menu = $menu == "create" ? new Menu() : Menu::findOrFail($menu);
        $validated = $request->validate([
            "parent_id" => "nullable",
            "title" => "required|string|max:40",
            "url" => "required|string",
            "icon" => "required|string",
            "section" => "required|string",
        ]);

        $menu->updateOrCreate(['id' => $menu->id], $validated);

        if (!$request->expectsJson()) {
            return redirect()->route('admin.menu.edit', $menu->id);
        }
        return APIResponse("success", "Menu Berhasil Disimpan");
    }

    public function destroy(Menu $menu, Request $request)
    {
        $menu->delete();

        if (!$request->expectsJson()) {
            return redirect('admin.menu.index');
        }
        return APIResponse("success", "Menu Berhasil Dihapus");
    }
}
