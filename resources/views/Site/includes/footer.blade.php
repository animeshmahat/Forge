<footer id="footer" class="footer">

    <div class="footer-content">
        <div class="container">

            <div class="row g-5">
                <div class="col-lg-4">
                    <h3 class="footer-heading">About Forge</h3>
                    <p>{!! $all_view['setting']->site_description !!}</p>
                    <p><a href="{{route('site.about_us')}}" class="footer-link-more">Learn More</a></p>
                </div>
                <div class="col-6 col-lg-2">
                    <h3 class="footer-heading">Navigation</h3>
                    <ul class="footer-links list-unstyled">
                        <li><a href="{{route('site.index')}}"><i class="bi bi-chevron-right"></i> Home</a></li>
                        <li><a href="{{route('site.about_us')}}"><i class="bi bi-chevron-right"></i> About us</a></li>
                        <li><a href="{{route('site.contact_us')}}"><i class="bi bi-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h3 class="footer-heading">Categories</h3>
                    <ul class="footer-links list-unstyled">
                        @if(isset($all_view['category']))
                        @foreach($all_view['category'] as $category)
                        @if($loop->index<9) <li><a href="{{route('site.category', $category->name)}}"><i class="bi bi-chevron-right"></i> {{$category->name}}</a></li>
                            @endif
                            @endforeach
                            @endif
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h3 class="footer-heading">Recent Posts</h3>

                    <ul class="footer-links footer-blog-entry list-unstyled">
                        @if(isset($all_view['recent_posts']))
                        @foreach($all_view['recent_posts'] as $row)
                        <li>
                            <a href="{{route('site.single_post', $row->slug)}}" class="d-flex align-items-center">
                                <img src="{{asset('/uploads/post/' . $row->thumbnail)}}" alt="" class="img-fluid me-3">
                                <div>
                                    <div class="post-meta d-block"><span class="date">{{$row->category->name}}</span> <span class="mx-1">&bullet;</span> <span>{{$row->created_at->format('d-M-Y')}}</span></div>
                                    <span>{{$row->title}}</span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="footer-legal">
        <div class="container">

            <div class="row justify-content-between">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="copyright">
                        © Copyright <strong><span>{{$all_view['setting']->site_name}}</span></strong>. All Rights Reserved
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
                        <a target="_blank" href="{{$all_view['setting']->social_profile_twitter}}" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a target="_blank" href="{{$all_view['setting']->social_profile_fb}}" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a target="_blank" href="{{$all_view['setting']->social_profile_insta}}" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a target="_blank" href="{{$all_view['setting']->social_profile_youtube}}" class="google-plus"><i class="bi bi-youtube"></i></a>
                        <a target="_blank" href="{{$all_view['setting']->social_profile_linkedin}}" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>

                </div>

            </div>

        </div>
    </div>

</footer>