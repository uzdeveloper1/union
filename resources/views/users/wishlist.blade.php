@extends( "layouts.master" )
@section('title', __('web.Cabinet'))
@push('css')
    <style>
        .nav-pills-custom .nav-link {
            color: #aaa;
            background: #fff;
            position: relative;
        }

        .nav-pills-custom .nav-link.active {
            color: #3F51B5;
            background: #fff;
        }
        .tab-pane{
            border-left: 0.25rem solid #3F51B5;
        }


        /* Add indicator arrow for the active tab */
        @media (min-width: 992px) {
            .nav-pills-custom .nav-link::before {
                content: '';
                display: block;
                border-top: 8px solid transparent;
                border-left: 10px solid #fff;
                border-bottom: 8px solid transparent;
                position: absolute;
                top: 50%;
                right: -10px;
                transform: translateY(-50%);
                opacity: 0;
            }
        }

        .nav-pills-custom .nav-link.active::before {
            opacity: 1;
        }

    </style>
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
    <section class="py-5 header">
        <div class="container py-4">
            <header class="text-center  text-white">
            </header>
            <div class="row">
                <div class="col-md-3">
                    <!-- Tabs nav -->
                    <div class="nav flex-column nav-pills nav-pills-custom" role="tablist" aria-orientation="vertical">
                        <a class="nav-link mb-3 p-3 shadow "  href="{{route('my.cabinet.info')}}">
                            <i class="fad fa-user mr-2 "></i>
                            <span class="font-weight-bold small text-uppercase">{{__('web.Personal information')}}</span>
                        </a>

                        <a class="nav-link mb-3 p-3 shadow active" href="{{route('my.cabinet.wishlist')}}">
                            <i class="fad fa-heart-circle mr-2"></i>
                            <span class="font-weight-bold small text-uppercase">{{__('web.Wishlist')}}</span>
                        </a>

                        <a class="nav-link mb-3 p-3 shadow" href="#">
                            <i class="fad fa-map-marker-alt mr-2 "></i>
                            <span class="font-weight-bold small text-uppercase">Reviews</span>
                        </a>

                        <a class="nav-link mb-3 p-3 shadow"  href="{{route('view.cart')}}">
                            <i class="fad fa-box-full mr-2"></i>
                            <span class="font-weight-bold small text-uppercase">{{__('web.Cart')}}</span>
                        </a>
                    </div>
                </div>


                <div class="col-md-9">
                    <!-- Tabs content -->
                    <div class="tab-content" >
                        <div class="tab-pane show active fade shadow rounded bg-white p-5">
                            <h4 class="font-italic mb-4 text-center">{{__('web.Wishlist')}}</h4>
                            <div class="row">
                                @if($wishlist !== null)
                                    @if($wishlist->count() > 0)
                                        @foreach($wishlist as $item)
                                            <div class="col-lg-12 in-cabinet-box">
                                                <div class="product-card product-card-2 d-sm-flex mt-30">
                                                    <div class="product-image">
                                                        <img class="rounded" src="{{Voyager::image($item->image[0])}}" alt="product">
                                                        @if ($item->new === 1 )
                                                            <div class="sticker new">
                                                                <span>{{__('web.New')}}</span>
                                                            </div>
                                                        @endif
                                                        @if($item->discount === 1)
                                                            <div class="sticker discount">
                                                                <span>-{{$item->discount_percent}}%</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="product-content media-body">
                                                        <h3 class="product-name"><a href="{{route('single.product', ['id' => $item->id])}}">{{$item->getTranslatedAttribute('name')}}</a></h3>
                                                        @if($item->discount === 1)
                                                            <span class="price">{{number_format($item->discount_price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                            <span class="price "><del class="text-danger">{{number_format($item->price,0, ',', ' '). ' '.__('Sum')}}</del></span>
                                                        @else
                                                            <span class="price">{{number_format($item->price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                        @endif
                                                        <div class="cart=btn mt-10 d-lg-flex">
                                                            <a class="rounded main-btn single-product-tag-show-modal" href="#" data-toggle="modal"  data-id="{{$item->id}}" ><i class="lni lni-eye"></i></a>
                                                            <a class="rounded my-sm-1 my-lg-0 mx-lg-1 mx-sm-0 in-cabinet  main-btn add-wishlist @if(inWish($item->id)) bg-danger border-0 active @endif " data-id="{{$item->id}}" href="#"><i class="lni lni-heart"></i> {{__('web.Wishlist')}}</a>
                                                            <a class="rounded main-btn add-to-cart border-0 @if(inCart($item->id)) bg-success @endif " data-id="{{$item->id}}" href="#"><i class="lni lni-cart-full"></i> </a>
                                                        </div>
                                                    </div>
                                                </div> <!-- product card -->
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-lg-12 d-flex justify-content-center mb-2">
                                            <h3 class="h3">{{__('web.Wishlist empty')}}</h3>
                                        </div>
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <a class="main-btn rounded" href="{{url('/')}}">{{__('web.Go to shopping')}}</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-lg-12 d-flex justify-content-center mb-2">
                                        <h3 class="h3">{{__('web.Wishlist empty')}}</h3>
                                    </div>
                                    <div class="col-lg-12 d-flex justify-content-center">
                                        <a class="main-btn rounded" href="{{url('/')}}">{{__('web.Go to shopping')}}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
