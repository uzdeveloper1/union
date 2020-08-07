<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--====== Title ======-->
    <title>@yield('title')</title>

    <!--====== LIGHT GALLERY ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/lightGallery-master/dist/css/lightgallery.css') }}">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('storage/logo/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('storage/logo/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('storage/logo/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('storage/logo/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('storage/logo/site.webmanifest')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/bootstrap.min.css') }}">

    <!--====== Animate css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/animate.css') }}">

    <!--====== FontAwesome css ======-->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <!--====== Line Icons css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/LineIcons.css') }}">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/magnific-popup.css') }}">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/slick.css') }}">

    <!--====== Range Slider css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/ion.rangeSlider.min.css') }}">

    <!--====== Nice Select css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/nice-select.css') }}">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/default.css') }}">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/css/style.css') }}">

    <!--====== Additional css ======-->
    <link rel="stylesheet" href="{{ asset('union/assets/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('union/assets/slick/slick.css') }}">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">

    @stack('css')

</head>

<body>

<!--====== PRELOADER PART START ======-->

{{--@include('components.preloader')--}}

<!--====== PRELOADER PART ENDS ======-->

<!--====== HEADER PART START ======-->
@yield('content')

<!--====== FOOTER PART START ======-->

@include( 'components.footer')
<!--====== FOOTER PART ENDS ======-->

<!--====== BACK TOP TOP PART START ======-->

<a href="#" class="back-to-top rounded"><i class="lni lni-chevron-up"></i></a>

<!--====== BACK TOP TOP PART ENDS ======-->

<!--====== MODAL PART START ======-->

<!-- Modal -->
<div class="modal rounded fade" id="exampleModalCenter" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog rounded modal-dialog-centered product-quick-view" role="document">
        <div class="modal-content rounded">
            <div class="modal-body">
                <a class="modal-close" href="#" data-dismiss="modal" aria-label="Close"><i class="lni lni-close"></i></a>
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8 col-sm-8">
                        <div class=" mt-30">
                            <div class="" id="details-image"></div> <!-- product image -->
                            <ul class="" id="product-thumbs"></ul> <!-- product thumbs -->
                        </div> <!-- product details image -->
                    </div>
                    <div class="col-lg-7">
                        <div class="product-details-content mt-25">
                            <h3 class="details-title" id="product-name"></h3>
                            <div class="details-price-rating d-sm-flex justify-content-between align-items-center">
                                <div class="price">
                                    <span class="price-text"><span id="product-price"></span> <del id="product-discount-price" class="text-danger"></del></span>
                                </div>
                                <div class="rating d-flex offers">
                                        <div class="main-btn border-0 d-none rounded bg-warning mx-lg-1" id="product_new">{{__('web.New')}}</div>
                                        <div class="main-btn border-0  d-none rounded mx-lg-1" id="product_discount_percent_box"><span> <span id="product_discount_percent"></span> {{__('web.SALE')}}</span></div>
                                </div>
                            </div> <!-- details price rating -->
                            <div class="details-overview my-1">
                                <div class="details-sub-title">
                                    <h4 class="sub-title">{{__('web.Model')}} : <span class="text-uppercase" id="product_model"></span></h4>
                                </div>
                            </div> <!-- details overview -->
                            <div class="details-overview my-1">
                                <div class="details-sub-title">
                                    <h4 class="sub-title">{{__('web.Category')}} : <span class="text-uppercase" id="product_category"></span></h4>
                                </div>
                            </div>
                            <div class="details-overview my-1">
                                <div class="details-sub-title">
                                    <h4 class="sub-title">{{__('web.Brand')}} : <span class="text-uppercase" id="product_brand"></span></h4>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" id="pro_options">
                            </div>
                            <div class="details-cart d-sm-flex align-items-center">
                                <div class="cart=btn mt-10 ">
                                    <a id="ajax_add_to_cart_btn" class="main-btn rounded add-to-cart" href="#" data-id=""><i class="lni lni-cart-full"></i>{{__('web.Add to cart')}}</a>
                                    <a id="ajax_wish_btn" class="main-btn rounded add-wishlist border-0" href="#" data-id=""><i class="lni lni-heart"></i></a>
                                </div>
                            </div> <!-- details cart -->

                            <div class="details-share d-flex align-items-center">
                                <span class="share">{{__('web.Share')}}:</span>
                                    <ul class="social">
                                        <li><a class="rounded" id="share_facebook"  target="_blank" href="#"><i class="lni lni-facebook-filled"></i></a></li>
                                        <li><a class="rounded" id="share_telegram" target="_blank" href="#"><i class="lni lni-telegram-original"></i></a></li>
                                    </ul>
                            </div> <!-- details share -->
                        </div> <!-- product details content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- modal body -->
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div>

<!--====== MODAL PART ENDS ======-->
<!--====== jquery js ======-->
<script src="{{ asset('union/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.5.1.js') }}"></script>


<!--====== Bootstrap js ======-->
<script src="{{ asset('js/app.js') }}"></script>


<!--====== Slick js ======-->
<script src="{{ asset('union/assets/js/slick.min.js') }}"></script>

<!--====== Magnific Popup js ======-->
<script src="{{ asset('union/assets/js/jquery.magnific-popup.min.js') }}"></script>

<!--====== Ajax Contact js ======-->
<script src="{{ asset('union/assets/js/ajax-contact.js') }}"></script>

<!--====== Range Slider js ======-->
<script src="{{ asset('union/assets/js/ion.rangeSlider.min.js') }}"></script>

<!--====== Nice Select js ======-->
<script src="{{ asset('union/assets/js/jquery.nice-select.min.js') }}"></script>

<!--====== Main js ======-->
<script src="{{ asset('union/assets/js/main.js') }}"></script>

<!--====== FontAwesome js ======-->
<script src="{{ asset('fontawesome/js/all.min.js') }}"></script>

<!--====== Additional js ======-->
@stack('scripts')

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
<script src="{{ asset('union/assets/js/slim_scroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('union/assets/lightGallery-master/lib/picturefill.min.js') }}"></script>
<script src="{{ asset('union/assets/lightGallery-master/dist/js/lightgallery-all.min.js') }}"></script>
<script src="{{ asset('union/assets/lightGallery-master/lib/jquery.mousewheel.min.js') }}"></script>
<script src="{{ asset('union/assets/slick/slick.min.js') }}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<script>
    $('.single-product-tag-show-modal').on('click', function () {
        let id = $(this).data('id');
        console.log(id);
        if(id !== null){
            $.ajax({
                url : '{{ route('single.product.ajax') }}',
                method : 'GET',
                data : {
                    'id' : id
                }
            }).done(function (data) {
                console.log(data);
                let modalBox = $('#exampleModalCenter');
                modalBox.find('#product-name').html('');
                modalBox.find('#product-name').html(data.name);
                modalBox.find('#product-price').html('');
                modalBox.find('#product_model').html('');
                modalBox.find('#product_model').html(data.model);
                modalBox.find('#product_category').html('');
                modalBox.find('#product_category').html(data.category);
                modalBox.find('#product_brand').html('');
                modalBox.find('#product_brand').html(data.brand);
                modalBox.find('#ajax_wish_btn').attr('data-id', data.id);
                modalBox.find('#ajax_add_to_cart_btn').attr('data-id', data.id);
                if(data.in_wish){
                    modalBox.find('#ajax_wish_btn').addClass('bg-danger').attr('data-id', data.id);
                }
                if(data.in_cart){
                    modalBox.find('#ajax_add_to_cart_btn').addClass('bg-success');
                }
                modalBox.find('#product_discount_percent_box').addClass('d-none');
                modalBox.find('#product_discount_percent').html('');
                if(data.discount){
                    modalBox.find('#product_discount_percent_box').removeClass('d-none');
                    modalBox.find('#product_discount_percent').html('-' + data.discount_percent + '%');
                }
                modalBox.find('#product_new').addClass('d-none');
                if(data.new){
                    modalBox.find('#product_new').removeClass('d-none');
                }
                modalBox.find('#product-discount-price').html('');
                if(data.discount_price){
                    modalBox.find('#product-discount-price').html(data.price + '{{__('Sum')}}');
                    modalBox.find('#product-price').html(data.discount_price + ' {{__('Sum')}}');
                }else{
                    modalBox.find('#product-price').html(data.price + ' {{__('Sum')}}');
                }
                let images = data.image;
                // console.log(images);
                let temp1 = '';
                let temp2 = '';
                let res2 = '';
                let res1 = '';
                $.each(images, function (index, value) {
                    temp1 = '<div class="single-product-image my-3"><img class="rounded" src="/storage/'+value+'" alt="product"></div>'
                    temp2 = '<li><div class="single-thumbs mx-1"><img class="rounded" src="/storage/'+value+'" alt="thumbs"></div></li>';
                    res1 += temp1;
                    res2 += temp2;
                });
                let pro_options = data.options;
                let pro_options_temp = '';
                $.each(pro_options, function(key,value){
                   pro_options_temp += '<div class="details-size"><div class="details-sub-title"><h4 class="sub-title">'+value.key+'</h4></div><ul class="size-itesms"><li><a class="active" >'+value.value+'</a></li></ul></div>'
                });
                let box1 = modalBox.find('#details-image');
                let pro_options_temp_box = modalBox.find('#pro_options');
                pro_options_temp_box.html('');
                pro_options_temp_box.html(pro_options_temp);
                modalBox.find('#share_facebook').attr('href', data.share_facebook_url);
                modalBox.find('#share_telegram').attr('href', data.share_telegram_url);

                // console.log(pro_options_temp)
                box1.html('');
                box1.removeClass('slick-initialized slick-slider');
                box1.html(res1);
                let box2 =  modalBox.find('#product-thumbs');
                box2.html('');
                box2.removeClass('slick-initialized slick-slider');
                box2.html(res2);

                modalBox.modal();
                box1.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '#product-thumbs',
                    infinite :false,
                    mobileFirst : true,
                    adaptiveHeight : true
                });
                box2.slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '#details-image',
                    centerPadding: '60px',
                    dots: true,
                    centerMode: true,
                    focusOnSelect: true,
                    arrows : true,
                    infinite :false,
                    mobileFirst : true,
                });

            })
        }

    });
</script>
<script>
    $('.add-wishlist').on('click', function (e) {
            e.preventDefault();
            let wish_btn = $(this);
            let id  = wish_btn.data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route('add.wish')}}',
                method: 'POST',
                data:{
                    id:id
                }
            }).done(function (data) {
                if(!data.exists){
                    wish_btn.addClass('active bg-danger border-0');
                }else{
                    wish_btn.removeClass('active bg-danger');

                    if(wish_btn.hasClass('in-cabinet')){
                        console.log('In Cabinet', wish_btn.parents('div.col-lg-12.in-cabinet-box'));
                        wish_btn.parents('div.col-lg-12.in-cabinet-box').remove();
                    }
                }
                $('.wishlist-box').html(data.total);
                console.log(data);
            })
    });
</script>
<script>
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();
        let add_to_cart_btn = $(this);
        let id_pro  = add_to_cart_btn.data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{route('add.cart')}}',
            method: 'POST',
            data:{
                id:id_pro
            }
        }).done(function (data) {
            if(!data.exists){
                add_to_cart_btn.addClass('active bg-success border-0');
            }
            toastr.success('Ok', '{{__("web.The product has been successfully added to your cart")}}',{
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
            });

            $('.shop-quantity-box').html(data.total);
            console.log(data);
        })
    });
</script>

</body>
</html>

