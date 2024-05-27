<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Forge</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- category -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.category.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Category</span></a>
    </li>

    <!-- tags -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.tags.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Tags</span></a>
    </li>

    <!-- posts -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.post.index') }}">
            <i class="fas fa-fw fa-blog"></i>
            <span>Blogs</span></a>
    </li>

    <!-- settings  -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span></a>
    </li>

</ul>
<!-- End of Sidebar -->