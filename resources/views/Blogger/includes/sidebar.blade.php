<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-left" href="{{ route('blogger.index') }}">
        <!-- <div class="sidebar-brand-text mx-3">Forge</div> -->
        <div class="logo py-4">
            @if(isset($all_view['setting']->logo))
            <img src="{{asset($all_view['setting']->logo)}}" alt="Forge" style="width: 160px; max-height: 60px;">
            @endif
        </div>
        <!-- <div class="sidebar-brand-icon">
            <i class="fas fa-pen"></i>
        </div> -->
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('blogger*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('blogger.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- posts -->
    <li class="nav-item {{ Request::is('blogger/post*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('blogger.post.index') }}">
            <i class="fas fa-fw fa-blog"></i>
            <span>Blogs</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->