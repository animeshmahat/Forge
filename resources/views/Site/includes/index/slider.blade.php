<!-- ======= Hero Slider Section ======= -->
<section id="hero-slider" class="hero-slider">
    <div class="container-md" data-aos="fade-in">
        <div class="row">
            <div class="col-12">
                <div class="swiper sliderFeaturedPosts">
                    <div class="swiper-wrapper">
                        @if(isset($data['post']))
                        @foreach($data['post'] as $row)
                        @if($loop->index < 5) <div class="swiper-slide">
                            <a href="{{route('site.single_post', $row->slug)}}" class="img-bg d-flex align-items-end" style="background-image: url('{{ asset('/uploads/post/' . $row->thumbnail) }}');">
                                <div class="img-bg-inner">
                                    <h2>{{ $row->title }}</h2>
                                    <p>{{ substr(strip_tags($row->description), 0, 50) }}...</p>
                                </div>
                            </a>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
                <div class="custom-swiper-button-next">
                    <span class="bi-chevron-right"></span>
                </div>
                <div class="custom-swiper-button-prev">
                    <span class="bi-chevron-left"></span>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    </div>
</section><!-- End Hero Slider Section -->