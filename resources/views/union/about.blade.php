@extends( "layouts.master" )
@section('title', $about->getTranslatedAttribute('title'))
@section( "content")
    <header class="header-area">
        @include( 'components.top-header')
        @include( 'components.header-logo-search')
        @include( 'components.menu')
    </header>
    <!--====== HEADER PART ENDS ======-->

    <!--====== OFFCANVAS MOBILE MENU PART START ======-->
    @include( 'components.mobile-menu')
    <!--====== OFFCANVAS MOBILE MENU PART ENDS ======-->
    <section class="about-page pt-40">
        <div class="container">
            <div class="row">
{{--                @dd($about)--}}
                <div class="col-md-12">
                    <div class="about-content mt-35">
                        <h1 class="about-title text-center text-uppercase">{{$about->getTranslatedAttribute('title')}}</h1>
                    </div> <!-- about content -->
                    <div class="about-image pt-40">
                        <img src="{{Voyager::image($about->image)}}" alt="About">
                    </div> <!-- about image -->
                </div>

            </div> <!-- row -->
            <div class="row pb-50">
                <div class="col-md-12">
                    <div class="py-2">
                        {!! $about->getTranslatedAttribute('body') !!}
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </section>
@endsection
@push( 'scripts')

@endpush



