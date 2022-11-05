<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">Zun Fuyuzora</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @foreach (SideMenu() as $menu)
        @if (!$menu['child'])
            <li class="nav-item">
                <a class="nav-link" href="{{ $menu['url'] }}">
                    <i class="{{ $menu['icon'] }}"></i>
                    <span>{{ $menu['title'] }}</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{$menu['title']}}"
                    aria-expanded="true" aria-controls="#{{$menu['title']}}">
                    <i class="{{ $menu['icon'] }}"></i>
                    <span>{{ $menu['title'] }}</span>
                </a>
                <div id="{{ $menu['title'] }}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @foreach ($menu['child'] as $child)
                        <a class="collapse-item" href="{{$child['url']}}">{{$child['title']}}</a>
                    @endforeach
                    </div>
                </div>
            </li>
        @endif
    @endforeach

    {{-- <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div> --}}


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
