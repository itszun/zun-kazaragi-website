<div class="mb-4">
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">{{ PageInfo()->page_name }}</h1>
        @yield('page_heading_content')
    </div>
    <p class="mb-4">{{ PageInfo()->page_description }}</a>.</p>
</div>
