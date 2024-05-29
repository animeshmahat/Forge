 <!-- ======= Header ======= -->
 <header id="header" class="header d-flex align-items-center fixed-top">
     <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

         <a href="{{route('site.index')}}" class="logo d-flex align-items-center">
             <!-- Uncomment the line below if you also wish to use an image logo -->
             <img src="{{asset($all_view['setting']->logo)}}" alt="">
         </a>

         <nav id="navbar" class="navbar">
             <ul>
                 <li><a href="{{route('site.index')}}">Home</a></li>
                 <li><a href="#">Empty</a></li>
                 <li class="dropdown"><a href="#"><span>Categories</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                     <ul>
                         @if(isset($all_view['category']) && $all_view['category']->isNotEmpty())
                         @foreach($all_view['category'] as $category)
                         @if($loop->index<7) <li><a href="{{route('site.category', $category->name)}}">{{$category->name}}</a>
                 </li>
                 @endif
                 @endforeach
                 @endif
             </ul>
             </li>
             <li><a href="#">About</a></li>
             <li><a href="{{route('site.contact_us')}}">Contact</a></li>
             </ul>
         </nav><!-- .navbar -->

         <div class="position-relative">
             <a href="{{$all_view['setting']->social_profile_fb}}" target="_blank" class="mx-2"><span class="bi-facebook"></span></a>
             <a href="{{$all_view['setting']->social_profile_twitter}}" target="_blank" class="mx-2"><span class="bi-twitter"></span></a>
             <a href="{{$all_view['setting']->social_profile_insta}}" target="_blank" class="mx-2"><span class="bi-instagram"></span></a>

             <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
             <i class="bi bi-list mobile-nav-toggle"></i>

             <!-- ======= Search Form ======= -->
             <div class="search-form-wrap js-search-form-wrap">
                 <form action="search-result.html" class="search-form">
                     <span class="icon bi-search"></span>
                     <input type="text" placeholder="Search" class="form-control">
                     <button class="btn js-search-close"><span class="bi-x"></span></button>
                 </form>
             </div><!-- End Search Form -->

         </div>

     </div>

 </header><!-- End Header -->