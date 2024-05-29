@extends('site.layouts.app')
@section('title', 'Forge')
@section('css')
<style>
    .img-fluid {
        max-width: 70vw;
        object-fit: contain;
    }
</style>
@endsection
@section('content')
<main id="main">

    <section class="single-post-content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 post-content" data-aos="fade-up">

                    <!-- ======= Single Post Content ======= -->
                    <div class="single-post">
                        <div class="post-meta"><span class="date">{{$data['post']->category->name}}</span> <span class="mx-1">&bullet;</span> <span>{{$data['post']->created_at->format('Y-m-d D')}}</span></div>
                        <div class="post-meta"><i class="fa fa-eye"></i> <span>{{$data['post']->views}} views</span></div>
                        <h1 class="mb-5">{{$data['post']->title}}</h1>

                        <figure class="my-4">
                            <img src="{{ asset('/uploads/post/' . $data['post']->thumbnail) }}" alt="" class="img-fluid">
                        </figure>
                        <p>{!! html_entity_decode($data['post']->description) !!}</p>
                        <div class="post-meta">Posted by {{$data['post']->user->name}} ({{$data['post']->user->username}})</div>

                    </div><!-- End Single Post Content -->

                    <!-- Comments -->
                    <div class="comments">
                        <h5 class="comment-title py-4">{{ $data['comments']->count() }} Comments</h5>
                        @foreach($data['comments'] as $comment)
                        @if(!$comment->parent_id)
                        <!-- Display only parent comments -->
                        <div class="comment d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-sm rounded-circle">
                                    <img class="avatar-img" src="{{ asset('assets/Site/usericon.jpg') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-2 ms-sm-3">
                                <div class="comment-meta d-flex align-items-baseline">
                                    <h6 class="me-2">{{ $comment->name }}</h6>
                                    <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-body">
                                    {{ $comment->message }}
                                </div>

                                @if($comment->replies->count() > 0)
                                <div class="comment-replies bg-light p-3 mt-3 rounded">
                                    <h6 class="comment-replies-title mb-4 text-muted text-uppercase">{{ $comment->replies->count() }} replies</h6>
                                    @foreach($comment->replies as $reply)
                                    <div class="reply d-flex mb-4">
                                        <div class="flex-shrink-0">
                                            <div class="avatar avatar-sm rounded-circle">
                                                <img class="avatar-img" src="{{ asset('assets/Site/usericon.jpg') }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2 ms-sm-3">
                                            <div class="reply-meta d-flex align-items-baseline">
                                                <h6 class="mb-0 me-2">{{ $reply->name }}</h6>
                                                <span class="text-muted">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="reply-body">
                                                {{ $reply->message }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                <a href="javascript:void(0);" class="reply-link" data-comment-id="{{ $comment->id }}" style="color:red;">Reply</a>

                                <!-- Reply Form -->
                                <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display:none;">
                                    <form action="{{ route('site.comment.store', ['post_id' => $data['post']->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $data['post']->id }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="mb-3">
                                            <label for="name-{{ $comment->id }}" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name-{{ $comment->id }}" name="name" placeholder="Enter Your Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email-{{ $comment->id }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email-{{ $comment->id }}" name="email" placeholder="Enter Your Email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="message-{{ $comment->id }}" class="form-label">Message</label>
                                            <textarea class="form-control" id="message-{{ $comment->id }}" name="message" rows="3" placeholder="Enter Your Message" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <!-- End Reply Form -->
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <!-- End Comments -->

                    <!-- Comments Form -->
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-12">
                            <h5 class="comment-title">Leave a Comment</h5>
                            <form action="{{ route('site.comment.store', ['post_id' => $data['post']->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $data['post']->id }}">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name">
                                        @error('name')
                                        <p class="alert alert-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" placeholder="Enter your email">
                                        @error('email')
                                        <p class="alert alert-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" placeholder="Enter your message" cols="10" rows="10"></textarea>
                                        @error('message')
                                        <p class="alert alert-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="col-12">
                                        <input type="submit" class="btn btn-primary" value="Post comment">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Comments Form -->

                </div>
                <div class="col-md-3">
                    <!-- ======= Sidebar ======= -->
                    <div class="aside-block">

                        <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill" data-bs-target="#pills-popular" type="button" role="tab" aria-controls="pills-popular" aria-selected="true">Popular</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill" data-bs-target="#pills-trending" type="button" role="tab" aria-controls="pills-trending" aria-selected="false">Trending</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill" data-bs-target="#pills-latest" type="button" role="tab" aria-controls="pills-latest" aria-selected="false">Latest</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            <!-- Popular -->
                            <div class="tab-pane fade show active" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
                                @if(isset($data['popularPosts']))
                                @foreach($data['popularPosts'] as $popular)
                                <div class="post-entry-1 border-bottom">
                                    <div class="post-meta"><span class="date">{{$popular->category->name}}</span> <span class="mx-1">&bullet;</span> <span>{{$popular->created_at->format('M d,Y')}}</span></div>
                                    <h2 class="mb-2"><a href="{{ route('site.single_post', $popular->slug)}}">{{$popular->title}}</a></h2>
                                    <span class="author mb-3 d-block">{{$popular->user->name}}</span>
                                </div>
                                @endforeach
                                @endif
                            </div> <!-- End Popular -->

                            <!-- Trending -->
                            <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">
                                @if(isset($data['trendingPosts']))
                                @foreach($data['trendingPosts'] as $trending)
                                <div class="post-entry-1 border-bottom">
                                    <div class="post-meta"><span class="date">{{$trending->category->name}}</span> <span class="mx-1">&bullet;</span> <span>{{$trending->created_at->format('M d,Y')}}</span></div>
                                    <h2 class="mb-2"><a href="{{ route('site.single_post', $trending->slug)}}">{{$trending->title}}</a></h2>
                                    <span class="author mb-3 d-block">{{$trending->user->name}}</span>
                                </div>
                                @endforeach
                                @endif
                            </div> <!-- End Trending -->

                            <!-- Latest -->
                            <div class="tab-pane fade" id="pills-latest" role="tabpanel" aria-labelledby="pills-latest-tab">
                                @if(isset($data['latest']))
                                @foreach($data['latest'] as $latest)
                                <div class="post-entry-1 border-bottom">
                                    <div class="post-meta"><span class="date">{{$latest->category->name}}</span> <span class="mx-1">&bullet;</span> <span>{{$latest->created_at->format('h:i A, d-M-Y')}}</span></div>
                                    <h2 class="mb-2"><a href="{{ route('site.single_post', $latest->slug)}}">{{$latest->title}}</a></h2>
                                    <span class="author mb-3 d-block">{{$latest->user->name}}</span>
                                </div>
                                @endforeach
                                @endif
                            </div> <!-- End Latest -->
                        </div>
                    </div>

                    <div class="aside-block">
                        <h3 class="aside-title">Categories</h3>
                        <ul class="aside-links list-unstyled">
                            @if(isset($data['categoriesWithMostPosts']))
                            @foreach($data['categoriesWithMostPosts'] as $category)
                            @if($loop->index<8) <li><a href="category.html"><i class="bi bi-chevron-right"></i> {{$category->name}}</a></li>
                                @endif
                                @endforeach
                                @endif
                        </ul>
                    </div><!-- End Categories -->

                    <div class="aside-block">
                        <h3 class="aside-title">Tags</h3>
                        <ul class="aside-tags list-unstyled">
                            @if(isset($data['tagsWithMostPosts']))
                            @foreach($data['tagsWithMostPosts'] as $tags)
                            @if($loop->index<20) <li><a href="category.html">{{$tags->name}}</a></li>
                                @endif
                                @endforeach
                                @endif
                        </ul>
                    </div><!-- End Tags -->

                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyLinks = document.querySelectorAll('.reply-link');
        replyLinks.forEach(link => {
            link.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                if (replyForm.style.display === 'none' || replyForm.style.display === '') {
                    replyForm.style.display = 'block';
                } else {
                    replyForm.style.display = 'none';
                }
            });
        });
    });
</script>

@endsection