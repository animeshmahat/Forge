@extends('site.layouts.app')

@section('title', 'About Us')

@section('css')
@endsection

@section('content')
<section>
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h1 class="page-title">About us</h1>
            </div>
        </div>
        <div class="row mb-5">
            <div class="d-md-flex post-entry-2 half">
                <a href="#" class="me-4 thumbnail">
                    <img src="{{asset($all_view['setting']->logo)}}" alt="" class="img-fluid">
                </a>
                <div class="ps-md-5 mt-4 mt-md-0">
                    <div class="post-meta mt-4">About us</div>
                    <h2 class="mb-4 display-4">{{$all_view['setting']->site_name}}</h2>

                    <p>{!! html_entity_decode($all_view['setting']->site_description) !!}</p>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('js')
@endsection