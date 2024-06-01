@extends('site.layouts.app')
@section('title', 'Forge')
@section('css')
<style>
    .img-fluid {
        max-width: 70vw;
        object-fit: contain;
    }

    .tab {
        overflow: hidden;
        border-bottom: 1px solid #ccc;
    }

    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
    }

    .tab button:hover {
        background-color: #ddd;
    }

    .tab button.active {
        background-color: #ccc;
    }

    .tabcontent {
        display: none;
        padding: 6px 12px;
        border-top: none;
    }
</style>
@endsection

@section('content')
<section class="single-post-content">
    <div class="container">
        <div class="row">
            <div class="col-md-9 post-content" data-aos="fade-up">
                <div class="single-post">
                    <div class="post-meta">
                        <span class="date">{{ $data['post']->category->name }}</span>
                        <span class="mx-1">&bullet;</span>
                        <span>{{ $data['post']->created_at->format('Y-m-d D') }}</span>
                        <span><i>({{ $data['readingTime'] }} minute read)</i></span>
                    </div>
                    <div class="post-meta">
                        <i class="fa fa-eye"></i>
                        <span>{{ $data['post']->views }} views</span>
                    </div>
                    @if($data['post']->created_at != $data['post']->updated_at)
                    <span style="font-weight: italic;">Updated at : {{ $data['post']->updated_at->format('D Y-m-d') }} at {{ $data['post']->updated_at->format('H:i A') }}</span>
                    <span>
                        <button class="btn btn-sm btn-outline-dark" id="summarizeBtn" style="font-family:'Times New Roman', Times, serif;">SUMMARIZE</button>
                    </span>
                    @endif
                    <h1 class="mb-5">{{ $data['post']->title }}</h1>

                    <figure class="my-4">
                        <img src="{{ asset('/uploads/post/' . $data['post']->thumbnail) }}" alt="" class="img-fluid">
                    </figure>
                    <p>{!! html_entity_decode($data['post']->description) !!}</p>
                    <div class="post-meta">Posted by {{ $data['post']->user->name }} ({{ $data['post']->user->username }})</div>
                </div>

                <!-- Comments -->
                <div class="comments">
                    <h5 class="comment-title py-4">{{ $data['comments']->count() }} Comments</h5>
                    @foreach($data['comments'] as $comment)
                    @if(!$comment->parent_id)
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
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>

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
                                    <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your email">
                                    @error('email')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" placeholder="Enter your message" cols="10" rows="10"></textarea>
                                    @error('message')
                                    <p class="alert alert-danger">{{ $message }}</p>
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
            </div>
            @include('site.includes.sidebar')
        </div>
    </div>
</section>

<!-- Summarization Modal -->
<div class="modal fade" id="summarizeModal" tabindex="-1" role="dialog" aria-labelledby="summarizeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summarizeModalLabel">Summary</h5>
            </div>
            <div class="modal-body">
                <!-- Tab links -->
                <div class="tab">
                    <button class="tablinks" onclick="openSummary(event, 'BulletPoints')" id="defaultOpen">Points</button>
                    <button class="tablinks" onclick="openSummary(event, 'Paragraph')">Paragraph</button>
                </div>

                <!-- Tab content -->
                <div id="Paragraph" class="tabcontent">
                    <p id="paragraphSummary">{!! $data['paragraph_summary'] !!}</p>
                </div>

                <div id="BulletPoints" class="tabcontent">
                    <ul id="bulletPointsSummary">
                        @if(is_array($data['bullet_point_summary']) && count($data['bullet_point_summary']) > 0)
                        @foreach($data['bullet_point_summary'] as $bullet)
                        <li>{!! $bullet !!}</li>
                        @endforeach
                        @else
                        <li>No bullet points available.</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <p>Press <span><i>Esc</i></span> to escape.</p>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summarizeBtn').click(function() {
            $('#summarizeModal').modal('show');
        });

        $('.reply-link').click(function() {
            var commentId = $(this).data('comment-id');
            $('#reply-form-' + commentId).toggle();
        });

        document.getElementById("defaultOpen").click();
    });

    function openSummary(evt, summaryType) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(summaryType).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@endsection