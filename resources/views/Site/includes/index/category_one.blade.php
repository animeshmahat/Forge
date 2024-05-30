    <!-- ======= Category One Category Section ======= -->
    <section class="category-section">
        <div class="container" data-aos="fade-up">

            <div class="section-header d-flex justify-content-between align-items-center mb-5">
                <h2>{{$data['category_one_name']}}</h2>
                <div><a href="category.html" class="more">See All {{$data['category_one_name']}}</a></div>
            </div>

            <div class="row">
                @if(isset($data['category_one_posts']))
                @foreach($data['category_one_posts'] as $post)
                <div class="col-md-9">
                    <div class="d-lg-flex post-entry-2">
                        @if($loop->first)
                        <a href="single-post.html" class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">
                            <img src="{{ asset('/uploads/post/' . $post->thumbnail) }}" alt="" class="img-fluid">
                        </a>
                        <div>
                            <div class="post-meta"><span class="date">{{$data['category_one_name']}}</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                            <h3><a href="single-post.html">{{$post->title}}</a></h3>
                            <p>{{ substr(strip_tags($post->description), 0,50) }}</p>
                            <div class="d-flex align-items-center author">
                                <div class="photo"><img src="assets/img/person-2.jpg" alt="" class="img-fluid"></div>
                                <div class="name">
                                    <h3 class="m-0 p-0">{{$post->user->name}}</h3>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            @if($loop->index == 2)
                            <div class="post-entry-1 border-bottom">
                                <a href="single-post.html"><img src="{{ asset('/uploads/post/' . $post->thumbnail) }}" alt="" class="img-fluid"></a>
                                <div class="post-meta"><span class="date">{{$data['category_one_name']}}</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                                <h2 class="mb-2"><a href="single-post.html">1{{$post->title}}</a></h2>
                                <span class="author mb-3 d-block">{{$post->user->name}}</span>
                                <p class="mb-4 d-block">{{ substr(strip_tags($post->description), 0,50) }}</p>
                            </div>
                            @endif
                            @if($loop->index == 3)
                            <div class="post-entry-1">
                                <div class="post-meta"><span class="date">{{$data['category_one_name']}}</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                                <h2 class="mb-2"><a href="single-post.html">{{$post->title}}</a></h2>
                                <span class="author mb-3 d-block">{{$post->user->name}}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-8">
                            @if($loop->index == 1)
                            <div class="post-entry-1">
                                <a href="single-post.html"><img src="{{ asset('/uploads/post/' . $post->thumbnail) }}" alt="" class="img-fluid"></a>
                                <div class="post-meta"><span class="date">{{$data['category_one_name']}}</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                                <h2 class="mb-2"><a href="single-post.html">{{$post->title}}</a></h2>
                                <span class="author mb-3 d-block">{{$post->user->name}}</span>
                                <p class="mb-4 d-block">{{ substr(strip_tags($post->description), 0,50) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

                <div class="col-md-3">
                    @if(isset($data['category_one_posts']))
                    @foreach($data['category_one_posts'] as $post)
                    <div class="post-entry-1 border-bottom">
                        <div class="post-meta"><span class="date">{{$data['category_one_name']}}</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                        <h2 class="mb-2"><a href="single-post.html">{{$post->title}}</a></h2>
                        <span class="author mb-3 d-block">{{$post->user->name}}</span>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section><!-- End Category One Category Section -->