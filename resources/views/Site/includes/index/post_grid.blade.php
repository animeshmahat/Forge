<!-- ======= Post Grid Section ======= -->
<section id="posts" class="posts">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">
            <div class="col-lg-4">
                @if(isset($data['random']))
                <div class="post-entry-1 lg">
                    <a href="{{ route('site.single_post', $data['random']->slug)}}"><img src="{{ asset('/uploads/post/' . $data['random']->thumbnail) }}" alt="" class="img-fluid"></a>
                    <div class="post-meta"><span class="date">{{$data['random']->category->name}}</span> <span class="mx-1">&bullet;</span> <span>{{$data['random']->created_at->format('Y-m-d')}}</span></div>
                    <h2><a href="{{ route('site.single_post', $data['random']->slug)}}">{{$data['random']->title}}</a></h2>
                    <p class="mb-4 d-block">{{ substr(strip_tags($data['random']->description), 0, 500) }}.....</p>
                    <div class="d-flex align-items-center author">
                        <div class="photo">@if(isset($data['random']->user->image))<img src="{{ asset('/uploads/user_image/' . $data['random']->user->image) }}" alt="{{$data['random']->title}}" class="img-fluid">
                            @else
                            <img src="{{asset('assets/site/blogger.gif')}}" alt="" class="img-fluid">
                            @endif
                        </div>
                        <div class="name">
                            <h3 class="m-0 p-0">{{$data['random']->user->name}}</h3>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-8">
                <div class="row g-5">
                    <div class="col-lg-4 border-start custom-border">
                        @if(isset($data['postbycategory']))
                        @foreach($data['postbycategory'] as $row)
                        @if($loop->index<3) <div class="post-entry-1">
                            <a href="{{ route('site.single_post', $row->slug)}}"><img src="{{ asset('/uploads/post/' . $row->thumbnail) }}" alt="" class="img-fluid"></a>
                            <div class="post-meta"><span class="date">{{$row->category->title}}</span> <span class="mx-1">&bullet;</span> <span>{{$row->created_at->format('Y-m-d')}}</span></div>
                            <h2><a href="{{ route('site.single_post', $row->slug)}}">{{$row->title}}</a></h2>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
                <div class="col-lg-4 border-start custom-border">
                    @if(isset($data['postbycategory2']))
                    @foreach($data['postbycategory2'] as $row)
                    @if($loop->index<3) <div class="post-entry-1">
                        <a href="{{ route('site.single_post', $row->slug)}}"><img src="{{ asset('/uploads/post/' . $row->thumbnail) }}" alt="" class="img-fluid"></a>
                        <div class="post-meta"><span class="date">{{$row->category->title}}</span> <span class="mx-1">&bullet;</span> <span>{{$row->created_at->format('Y-m-d')}}</span></div>
                        <h2><a href="{{ route('site.single_post', $row->slug)}}">{{$row->title}}</a></h2>
                </div>
                @endif
                @endforeach
                @endif
            </div>

            <!-- Trending Section -->
            <div class="col-lg-4">

                <div class="trending">
                    <h3><i class="fa-solid fa-fire"></i> Trending</h3>
                    <ul class="trending-post">
                        @if(isset($data['trending']))
                        @foreach($data['trending'] as $key=>$row)
                        @if($loop->index<6) <li>
                            <a href="{{ route('site.single_post', $row->slug)}}">
                                <span class="number">{{$key+1}}</span>
                                <h3>{{$row->title}}</h3>
                                <span class="author">{{$row->user->name}}</span>
                            </a>
                            </li>
                            @endif
                            @endforeach
                            @endif
                    </ul>
                </div>

            </div> <!-- End Trending Section -->
            <div class="custom-swiper-button-prev">
                <span class="bi-chevron-left"></span>
            </div>

            <div class="swiper-pagination"></div>
        </div>
    </div>
    </div>
    </div>
</section><!-- End Hero Slider Section -->


</div>
</div>

</div> <!-- End .row -->
</div>
</section> <!-- End Post Grid Section -->