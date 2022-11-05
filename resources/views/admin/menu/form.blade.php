@extends('admin._template.main')

@section('content')
    @include('admin._components.page_heading')

    <div class="card shadow mb-4 col-sm-6 p-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Menu</h6>
        </div>
        <div class="card-body">
            <form action="" cemes="form" method="POST" cemes-redirect={{ url()->previous() }}>
                <div class="form-group row align-items-center">
                    <label for="#parent_id" class="col-sm-2">Parent</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="">- None -</option>
                            @foreach (PageInfo()->form['parent_id_options'] as $o)
                                <option value="{{ $o['id'] }}" {{$menu->optIsSelected($o['id']) }}>{{ $o['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="#title" class="col-sm-2">Title</label>
                    <div class="col-sm-10">
                        <input type="text" id="title" name="title" placeholder="Title" class="form-control" value="{{ $menu->title }}">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="#icon" class="col-sm-2">Icon</label>
                    <div class="col-sm-10">
                        <input type="text" id="icon" name="icon" placeholder="fas fa-icon" class="form-control" value="{{ $menu->icon ?? "fas fa-fw fa-wrench" }}">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="#url" class="col-sm-2">URL</label>
                    <div class="col-sm-10">
                        <input type="text" id="url" name="url" placeholder="http://" class="form-control" value="{{ $menu->url }}">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="#section" class="col-sm-2">Section</label>
                    <div class="col-sm-10">
                        <input type="text" id="section" name="section" value="900"  class="form-control" value="{{ $menu->section }}">
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.menu.index') }}" class="btn border">Kembali</a>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
