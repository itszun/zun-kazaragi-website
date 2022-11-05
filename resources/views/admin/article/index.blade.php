@extends('admin._template.main')

@section('page_heading_content')
    <a href="{{ route('admin.article.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus-circle fa-sm text-white-50"></i> Buat Artikel </a>
@endsection




@section('content')
    @include('admin._components.page_heading')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Article</h6>
        </div>
        <div class="card-body">
            <x-datatable.table
                sourceUrl="{{ PageInfo()->data['datatable_url'] }}"
                tableHeaders="{{ PageInfo()->data['datatable_headers'] }}"
                >
            </x-datatable.table>
        </div>
    </div>
@endsection
