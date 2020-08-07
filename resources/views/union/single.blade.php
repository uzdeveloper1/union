@extends( "layouts.master" )
@section('title', $product->getTranslatedAttribute('name'). ' | ' . $product->category->getTranslatedAttribute('name'))
@push('css')

@endpush
@section( "content")
    <header class="header-area">
        @include( 'components.top-header')
        @include( 'components.header-logo-search')
        @include( 'components.menu')
    </header>

    <!--====== OFFCANVAS MOBILE MENU PART START ======-->
    @include( 'components.mobile-menu')
    <!--====== OFFCANVAS MOBILE MENU PART ENDS ======-->

    <!--====== PRODUCT DETAILS PART START ======-->
    @isset($product)
        <section class="product-details-area pt-30 pb-80">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8 col-sm-8">
                        <div class="product-images mt-50 p-3">
                                <div class="product-image-slick box-shadow-image rounded my-2" id="lightgallery">
                                        @if (isset($product->image) && $product->image !== null)
                                            @foreach($product->image as $image)
                                                <div class="product-image" data-src="{{ Voyager::image($image)}} ">
                                                        <img class="rounded " src="{{ Voyager::image($image) }}"  alt="Product">
                                                </div>
                                            @endforeach
                                        @endif
                                </div> <!-- product image -->
                            <div class="product-image-thumbs-slick py-2">
                                @if ($product->image !== null)
                                    @foreach($product->image as $image)
                                        <div class="single-image-thumb mx-1">
                                            <img class="rounded " src="{{ Voyager::image($image) }}"  alt="image-thumb">
                                        </div>
                                    @endforeach
                                @endif
                            </div> <!-- product thumbs -->
                        </div> <!-- product details image -->
                    </div>
                    <div class="col-lg-7">
                        <div class="product-details-content mt-45">
    {{--                        @dump($product)--}}
                            <h3 class="details-title">{{ $product->getTranslatedAttribute('name') }}</h3>
                            <div class="details-price-rating d-sm-flex justify-content-between align-items-center">
                                <div class="price my-2">
                                    @if($product->discount === 1)
                                        <span class="price-text mr-sm-1">{{number_format($product->discount_price,0, ',', ' '). ' '.__('Sum')}} </span>
                                        <span class="price text-danger ml-sm-1"> <del> {{number_format($product->price,0, ',', ' '). ' '.__('Sum')}}</del></span>
                                    @else
                                        <span class="price-text">{{number_format($product->price,0, ',', ' '). ' '.__('Sum')}}</span>
                                    @endif
                                </div>
                                <div class="rating d-flex justify-content-between">
                                    @if ($product->new === 1)
                                        <div class="main-btn border-0 rounded bg-warning mx-lg-1">{{__('web.New')}}</div>
                                    @endif
                                    @if($product->discount === 1)
                                         <div class="main-btn border-0 rounded mx-lg-1"><span>- {{$product->discount_percent}}% {{__('web.SALE')}}</span></div>
                                    @endif
                                </div>
                            </div> <!-- details price rating -->

                            <div class="details-overview my-1">
                                <div class="details-sub-title">
                                    <h4 class="sub-title">{{__('web.Model')}} : <span class="text-uppercase">{{$product->model}}</span></h4>
                                </div>
                            </div> <!-- details overview -->
                            <div class="details-overview my-1">
                                <div class="details-sub-title">
                                    <h4 class="sub-title">{{__('web.Category')}} : <span class="text-uppercase">{{$product->category->getTranslatedAttribute('name')}}</span></h4>
                                </div>
                            </div>
                            <div class="details-overview my-1">
                                <div class="details-sub-title">
                                    <h4 class="sub-title">{{__('web.Brand')}} : <span class="text-uppercase">{{$product->brand->name}}</span></h4>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                @foreach ($product->options as $option)
                                    <div class="details-size mx-lg-1">
                                        <div class="details-sub-title">
                                            <h4 class="sub-title text-uppercase">{{$option->optiontype->getTranslatedAttribute('name')}}</h4>
                                        </div>
                                        <ul class="size-itesms">
                                            <li ><a class="rounded active">{{$option->getTranslatedAttribute('value')}}</a></li>
                                        </ul>
                                    </div> <!-- details size -->
                                @endforeach
                            </div>

                            <div class="details-cart d-sm-flex align-items-center">
                                <div class="cart=btn mt-10">
                                    <a class="main-btn rounded add-to-cart border-0 @if(inCart($product->id)) bg-success @endif" href="#" data-id="{{$product->id}}"><i class="lni lni-cart-full"></i>{{__('web.Add to cart')}}</a>
                                    <a class="main-btn rounded add-wishlist @if(inWish($product->id)) bg-danger active border-0 @endif" href="#" data-id="{{$product->id}}"><i class="lni lni-heart"></i></a>
                                </div>
                            </div> <!-- details cart -->
                            <div class="details-share d-flex align-items-center">
                                <span class="share">{{__('web.Share')}}:</span>
                                <ul class="social">
                                    <li><a class="rounded" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{Request::fullUrl()}}"><i class="lni lni-facebook-filled"></i></a></li>
                                    <li><a class="rounded" target="_blank" href="https://t.me/share/url?url={{Request::fullUrl()}}"><i class="lni lni-telegram-original"></i></a></li>
                                </ul>
                            </div> <!-- details share -->
                        </div> <!-- product details content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </section>

        <!--====== PRODUCT DETAILS PART ENDS ======-->

        <!--====== PRODUCT TAB PART START ======-->

        <section class="product-tab-area pt-80 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="product-tab-menu">
                                <ul class="nav" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="active rounded" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">{{ __('Description')}}</a>
                                    </li>
                                </ul>
                            </div> <!-- product tab menu -->
                            <div class="product-tab-content">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane  fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                        <div class="single-tab-content rounded description-tabs">
                                            {!! $product->getTranslatedAttribute('description') !!}
                                        </div> <!-- single tab Content -->
                                    </div>
                                </div>
                            </div> <!-- product tab content -->
                        </div> <!-- product tab -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </section>
        @php
            $count = $product->tags->count();
        @endphp
        @if ($count > 0)
            <!--====== PRODUCT TAB PART ENDS ======-->
            <section class="featured-products-area pt-70 pb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title text-center pb-20">
                                <h5 class="title">{{__('Similar Products')}}</h5>
                                <span class="line"></span>
                            </div> <!-- section title -->
                        </div>
                    </div> <!-- row -->
                    <div class="row justify-content-center">
                        <div class="col-xl-12 col-md-11 col-sm-11 col-10">
                            <div class="row featured-products-active">
                                @php
                                    $count = $product->tags->count();
                                @endphp
                                @if ($count > 0)
                                    @foreach($product->tags as $tag)
                                        <div class="
                                        @if($count === 1)
                                            col-lg-12
                                        @elseif ($count===2)
                                            col-lg-6
                                        @elseif ($count===3)
                                            col-lg-4
                                        @else
                                            col-lg-3
                                        @endif
                                            ">
                                            <div class="product-card rounded text-center mt-30 mb-30">
                                                <div class="product-image">
                                                    <img src="{{ Voyager::image($tag->image[0]) }}" alt="product" class="rounded">
                                                </div>
                                                <div class="product-content rounded">
                                                    <h5 class="product-name"><a href="{{ route('single.product', ['id' => $tag->id]) }}">{{$tag->getTranslatedAttribute('name')}}</a></h5>
                                                    @if($tag->discount === 1)
                                                        <span class="price">{{number_format($tag->discount_price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                        <span class="price text-danger"><del>{{number_format($tag->price,0, ',', ' '). ' '.__('Sum')}}</del></span>
                                                    @else
                                                        <span class="price">{{number_format($tag->price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                    @endif
                                                    <ul class="actions">
                                                        <li><a class="rounded single-product-tag-show-modal" href="#" data-toggle="modal"  data-id="{{$tag->id}}" ><i class="lni lni-eye"></i></a></li>
                                                        <li><a class="rounded add-wishlist" href="#" data-id="{{$tag->id}}"><i class="lni lni-heart"></i></a></li>
                                                        <li><a class="rounded add-to-cart border-0 @if(inCart($tag->id)) bg-success @endif" href="#" data-id="{{$tag->id}}"><i class="lni lni-cart-full"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div> <!-- product card -->
                                        </div>
                                    @endforeach
                                @endif
                            </div> <!-- row -->
                        </div> <!-- row -->
                    </div> <!-- row -->
                </div> <!-- container -->
            </section>
        @endif

    @endisset

@endsection
@push( 'scripts')

    <script>
        $(document).ready(function(){
            $('#lightgallery').lightGallery({
                selector: '.product-image'
            });
        });
        $('.product-image-slick').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.product-image-thumbs-slick',
            infinite :false,
            mobileFirst : true,
            adaptiveHeight : true
        });
        $('.product-image-thumbs-slick').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.product-image-slick',
            dots: true,
            centerMode: true,
            focusOnSelect: true,
            arrows : true,
            infinite :false,
            mobileFirst : true,
        });
    </script>
@endpush
