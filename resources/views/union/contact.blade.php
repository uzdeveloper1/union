@extends( "layouts.master" )
@section('title', __('web.Contact'))
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
    <section class="contact-page pt-50 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">{{__('web.Contact')}}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="contact-info d-flex mt-30">
                        <div class="contact-icon">
                            <i class="lni lni-map-marker"></i>
                        </div>
                        <div class="contact-contant media-body">
                            <p class="text">{{setting('site.address')}}</p>
                        </div>
                    </div> <!-- contact info -->
                </div>
                <div class="col-md-4">
                    <div class="contact-info d-flex mt-30">
                        <div class="contact-icon">
                            <a href="tel:{{setting('site.phone')}}">
                                <i class="lni lni-phone"></i>
                            </a>
                        </div>
                        <div class="contact-contant media-body">
                            <p class="text">
                                <a href="tel:{{setting('site.phone')}}">
                                    {{setting('site.phone')}}
                                </a>
                            </p>
                        </div>
                    </div> <!-- contact info -->
                </div>
                <div class="col-md-4">
                    <div class="contact-info d-flex mt-30">
                        <div class="contact-icon">
                            <a href="mailto:{{setting('site.e_mail')}}">
                                <i class="lni lni-envelope"></i>
                            </a>
                        </div>
                        <div class="contact-contant media-body">
                            <p class="text">
                                <a href="mailto:{{setting('site.e_mail')}}">{{setting('site.e_mail')}}</a>
                            </p>
                        </div>
                    </div> <!-- contact info -->
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="col-md-12 my-1">
                    <h3 class="text-center">{{__('web.Social networks')}}</h3>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                    <div class="contact-info d-flex mt-30 mx-1">
                        <div class="contact-icon">
                            <a href="{{setting('site.telegram')}}">
                                <i class="lni lni-telegram"></i>
                            </a>
                        </div>
                    </div> <!-- contact info -->
                    <div class="contact-info d-flex mt-30 mx-1">
                        <div class="contact-icon">
                            <a href="{{setting('site.instagram')}}">
                                <i class="lni lni-instagram"></i>
                            </a>
                        </div>
                    </div> <!-- contact info -->
                    <div class="contact-info d-flex mt-30 mx-1">
                        <div class="contact-icon">
                            <a href="{{ setting('site.facebook') }}">
                                <i class="lni lni-facebook-original"></i>
                            </a>
                        </div>
                    </div> <!-- contact info -->

            </div> <!-- row -->
        </div> <!-- container -->
    </section>


    <div class="contact-map">
        <div class="gmap_canvas">
            {!! setting('site.map') !!}
        </div>
    </div> <!-- contact map -->
@endsection
@push( 'scripts')

@endpush


