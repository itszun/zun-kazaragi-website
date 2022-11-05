<?php

namespace App\Models;

use App\Contracts\ActionButton;
use App\Traits\HasActionButton;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model implements ActionButton
{
    use HasFactory, HasActionButton;
    public $timestamps = false;
    protected $guarded = ["id"];
    protected $appends = [
        "title_with_parent"
    ];

    public function parent() {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }
    public function child() {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function getTitleWithParentAttribute() {
        return ($this->parent ? $this->parent->title." / " : "").$this->title;
    }

    public static function getOptions() {
        return Menu::select('id', 'title')->where('parent_id', null)->get()->toArray();
    }

    public function optIsSelected($id = null) {
        return $this->parent_id == $id ? "selected" : "";
    }

    public function sideMenu() {
        return Menu::with('child')->where('parent_id', null)->orderBy('section')->get()->toArray();
    }

    public function actionButtonOptions(): array
    {
        return [
            'edit' => [
                'icon' => 'fa fa-eye',
                'url' => route('admin.menu.edit', $this->id),
            ],
            'hapus' => [
                'icon' => 'fa fa-trash',
                'url' =>  route('admin.menu.destroy', $this->id),
            ],
        ];
    }
}
