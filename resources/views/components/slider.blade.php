<section class="slider-area slider-active">
    @php
        $locale = Session::get('locale');
    @endphp
    @foreach($banners as $banner)
        <div class="single-slider bg_cover" style="background-image: url('{{ asset('storage/'.str_replace('\\', '/', $banner->images)) }}')">
            <div class="container">
                <div class="row @if($banner->position === 'left') justify-content-end @endif">
                    <div class="col-lg-6">
                        <div class="slider-content @if($banner->position === 'left') text-right @endif ">
                            <h5 class="sub-title text-secondary" data-animation="fadeInDown" data-delay="0.3s">{{ $banner->getTranslatedAttribute('short_description', $locale, 'en')  ?? ''}}</h5>
                            <h2 class="slider-title text-secondary text-capitalize" data-animation="fadeInLeft" data-delay="0.5s">{{ $banner->getTranslatedAttribute('name', $locale, 'en') ?? ''}}</h2>
                            <p class="text" data-animation="fadeInLeft" data-delay="0.7s">{{ $banner->getTranslatedAttribute('description', $locale, 'en') ?? ''}}</p>
                            <a class="main-btn rounded" data-animation="fadeInUp" data-delay="0.9s" href="{{ $banner->url ?? '#' }}"><i class="fad fa-shopping-cart"></i> {{__('web.Start shopping')}}</a>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
    @endforeach
</section>
