<footer class="footer-area">
    <div class="footer-widget pt-40 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-address pt-35">
                        <h4 class="footer-title">{{__('web.Contact')}}</h4>
                        <ul>
                            <li>
                                <div class="single-address d-flex">
                                    <div class="address-icon">
                                        <i class="lni lni-home"></i>
                                    </div>
                                    <div class="address-content media-body">
                                        <p class="text">{{setting('site.address')}}</p>
                                    </div>
                                </div> <!-- single address -->
                            </li>
                            <li>
                                <div class="single-address d-flex">
                                    <div class="address-icon">
                                        <a href="tel:{{setting('site.phone')}}">
                                            <i class="lni lni-phone"></i>
                                        </a>
                                    </div>
                                    <div class="address-content media-body">
                                        <p class="text"><a href="tel:{{setting('site.phone')}}">{{setting('site.phone')}}</a></p>
                                    </div>
                                </div> <!-- single address -->
                            </li>
                            <li>
                                <div class="single-address d-flex">
                                    <div class="address-icon">
                                        <a href="mailto:{{setting('site.e_mail')}}">
                                            <i class="lni lni-envelope"></i>
                                        </a>
                                    </div>
                                    <div class="address-content media-body">
                                        <p class="text"><a href="mailto:{{ setting('site.e_mail') }}">{{ setting('site.e_mail') }}</a></p>
                                    </div>
                                </div> <!-- single address -->
                            </li>
                        </ul>
                    </div> <!-- footer address -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-link pt-35">
                        <h4 class="footer-title">{{__('web.USEFUL LINKS')}}</h4>
                        <ul>
                            <li><a href="#">{{__('web.My Account')}}</a></li>
                            <li><a href="{{route('contact')}}">{{__('web.Contact')}}</a></li>
                            <li><a href="#">{{__('web.Checkout')}}</a></li>
                            <li><a href="#">{{__('web.Wishlist')}}</a></li>
                            <li><a href="{{route('about')}}">{{__('web.About us')}}</a></li>
                        </ul>
                    </div> <!-- footer link -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-newsletter pt-35">
                        <h4 class="footer-title mb-25">{{__('web.Social networks')}}</h4>
                        <div class="footer-address">
                            <ul class="d-flex justify-content-lg-between justify-content-around justify-content-md-between">
                                <li>
                                    <div class="single-address d-flex">
                                        <div class="address-icon">
                                            <a href="{{setting('site.telegram')}}">
                                                <i class="lni lni-telegram"></i>
                                            </a>
                                        </div>
                                    </div> <!-- single address -->
                                </li>
                                <li>
                                    <div class="single-address d-flex">
                                        <div class="address-icon">
                                            <a href="{{setting('site.instagram')}}">
                                                <i class="lni lni-instagram"></i>
                                            </a>
                                        </div>
                                    </div> <!-- single address -->
                                </li>
                                <li>
                                    <div class="single-address d-flex">
                                        <div class="address-icon">
                                            <a href="{{setting('site.facebook')}}">
                                                <i class="lni lni-facebook-oval"></i>
                                            </a>
                                        </div>
                                    </div> <!-- single address -->
                                </li>
                            </ul>
                        </div>
                    </div> <!-- footer NEWSLETTER -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- footer widget -->

    <div class="footer-copyright pt-10 pb-20">
        <div class="container">
            <div class="copyright-payment d-md-flex align-items-center justify-content-between">
                <div class="copyright text-center pt-10">
                    <p class="text">{{__('web.All copyrights reserved')}} © {{date('Y')}} {{config('app.name')}}</p>
                </div> <!-- copyright -->
                <div class="payment text-center pt-10 d-flex justify-content-around">
                    <div  class="mx-1">
                        <img src="{{ asset('union/assets/images/humo.jpg') }}"  alt="payment" height="30" >
                    </div>
                    <div class="mx-1">
                        <img src="{{ asset('union/assets/images/click.png') }}" alt="payment" height="30" >
                    </div>
                    <div class="mx-1">
                        <img src="{{ asset('union/assets/images/payme.png') }}" alt="payment" height="30" >
                    </div>

                </div> <!-- payment -->
            </div> <!-- copyright payment -->
        </div> <!-- container -->
    </div> <!-- footer copyright -->
</footer>

