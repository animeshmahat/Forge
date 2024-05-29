@extends('site.layouts.app')
@section('title', 'Contact Us')

@section('css')

@endsection
@section('content')
<section id="contact" class="contact mb-5">
    <div class="container" data-aos="fade-up">

        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h1 class="page-title">Contact us</h1>
            </div>
        </div>

        <div class="row gy-4">
            @if(isset($all_view['setting']))
            <div class="col-md-4">
                <div class="info-item">
                    <i class="bi bi-geo-alt"></i>
                    <h3>Address</h3>
                    <address>{{$all_view['setting']->site_address}}</address>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-item info-item-borders">
                    <i class="bi bi-phone"></i>
                    <h3>Phone Number</h3>
                    <p><a href="{{$all_view['setting']->site_phone}}">{{$all_view['setting']->site_phone}}</a></p><br>
                    <p><a href="{{$all_view['setting']->site_mobile}}">{{$all_view['setting']->site_mobile}}</a></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-item">
                    <i class="bi bi-envelope"></i>
                    <h3>Email</h3>
                    <p><a href="{{$all_view['setting']->site_email}}">{{$all_view['setting']->site_email}}</a></p>
                </div>
            </div>
            @endif
        </div>

        <div class="form mt-5">
            @if(session('success'))
            <div id="flash-message" data-message="{{ session('success') }}"></div>
            @endif
            <form action="{{route('site.contact.store')}}" method="POST" role="form" class="php-email-form">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                </div>
                <div class="my-3">
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
        </div>
        <!-- End Contact Form -->

    </div>
</section>
@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            const message = flashMessage.getAttribute('data-message');
            if (message) {
                const sentMessageDiv = document.querySelector('.sent-message');
                sentMessageDiv.style.display = 'block';
                sentMessageDiv.innerText = message;
            }
        }
    });
</script>
@endsection