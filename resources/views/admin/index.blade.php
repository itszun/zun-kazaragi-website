@extends('admin._template.main')

@section('page_heading_content')
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
@endsection

@section('content')
    @include('admin._components.page_heading', ['title' => 'Dashboard'])


@endsection
