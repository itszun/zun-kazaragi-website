@extends('admin._template.main')

@section('content')
    <!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="500">500</div>
        <p class="lead text-gray-800 mb-5">Internal Server Error</p>
        <p class="text-gray-500 mb-0">It looks like you got us on problem...</p>
        <a href="index.html">&larr; Back to Dashboard</a>
    </div>
@endsection
