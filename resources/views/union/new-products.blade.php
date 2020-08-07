@extends( "layouts.master" )
@section('title', __('web.New Products'))
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

    <!--====== CATEGORY PAGE PART START ======-->

    <section class="category-page pt-50 pb-80">
        <div class="container">
            @if ($new_categories->count() > 0)
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="category-sidebar">
                            <div class="category-search mt-30 card p-md-3 p-sm-3 p-lg-3">
                                <h4 class="text-center">{{__('web.New Products')}}</h4>
                            </div>
                            <div class="category-list mt-30">
                                <div class="category-title">
                                    <a href="{{route('new.products')}}">
                                        <h4 class="title text-uppercase">{{__('web.Categories')}}</h4>
                                    </a>
                                </div>
                                <div class="category-list-items">
                                    <ul class="list-items">
                                        @foreach($new_categories as $new_category)
                                            <li><a href="{{route('new.products', ['category_id' => $new_category->id])}}">{{$new_category->getTranslatedAttribute('name')}}<span>({{$new_category->products->count()}})</span></a></li>
                                        @endforeach
                                    </ul>
                                </div> <!-- category list items -->
                            </div> <!-- category list -->

                        </div> <!-- category sidebar -->
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="category-product pt-30">
                            <div class="product-option d-flex justify-content-between">
                                <div class="shop-tab">
                                    <ul class="nav" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="active" id="grid-tab" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="true"><i class="lni lni-grid-alt"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false"><i class="lni lni-list"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div> <!-- product option -->
                            <div class="shop-product">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                                        <div class="product-grid">
                                            <div class="row">
                                                @foreach($new_categories as $new_category)
                                                    @foreach($new_category->products as $product)
                                                        @if ($product !== null)
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="product-card text-center mt-30 rounded">
                                                                        <div class="product-image rounded">
                                                                            <img class="rounded" src="{{Voyager::image($product->image[0])}}" alt="product">
                                                                            @if ($product->new === 1 )
                                                                                <div class="sticker new">
                                                                                    <span>{{__('web.New')}}</span>
                                                                                </div>
                                                                            @endif
                                                                            @if($product->discount === 1)
                                                                                <div class="sticker discount">
                                                                                    <span>-{{$product->discount_percent}}%</span>
                                                                                </div>
                                                                            @endif

                                                                        </div>
                                                                        <div class="product-content rounded">
                                                                            <h5 class="product-name"><a href="{{route('single.product', ['id' => $product->id])}}">{{$product->getTranslatedAttribute('name')}}</a></h5>

                                                                            @if($product->discount === 1)
                                                                                <span class="price">{{number_format($product->discount_price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                                                <span class="price text-danger"><del class="text-danger">{{number_format($product->price,0, ',', ' '). ' '.__('Sum')}}</del></span>
                                                                            @else
                                                                                <span class="price">{{number_format($product->price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                                            @endif
                                                                            <ul class="actions">
                                                                                <li ><a class="rounded single-product-tag-show-modal" href="#" data-toggle="modal"  data-id="{{$product->id}}" ><i class="lni lni-eye"></i></a></li>
                                                                                <li><a class="rounded add-wishlist @if(inWish($product->id)) bg-danger border-0 active @endif " href="#" data-id="{{$product->id}}"><i class="lni lni-heart"></i></a></li>
                                                                                <li><a class="rounded add-to-cart border-0 @if(inCart($product->id)) bg-success @endif" href="#" data-id="{{$product->id}}"><i class="lni lni-cart-full"></i></a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div> <!-- product card -->
                                                                </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach


                                            </div> <!-- row -->
                                        </div> <!-- product grid -->
                                    </div>
                                    <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                                        <div class="product-list">
                                            <div class="row">
                                                @foreach($new_categories as $new_category)
                                                    @foreach($new_category->products as $product)
                                                        @if ($product !== null)
                                                            <div class="col-lg-12">
                                                                <div class="product-card product-card-2 d-sm-flex mt-30">
                                                                    <div class="product-image">
                                                                        <img class="rounded" src="{{Voyager::image($product->image[0])}}" alt="product">
                                                                        @if ($product->new === 1 )
                                                                            <div class="sticker new">
                                                                                <span>{{__('web.New')}}</span>
                                                                            </div>
                                                                        @endif
                                                                        @if($product->discount === 1)
                                                                            <div class="sticker discount">
                                                                                <span>-{{$product->discount_percent}}%</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="product-content media-body">
                                                                        <h3 class="product-name"><a href="{{route('single.product', ['id' => $product->id])}}">{{$product->getTranslatedAttribute('name')}}</a></h3>
                                                                        @if($product->discount === 1)
                                                                            <span class="price">{{number_format($product->discount_price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                                            <span class="price "><del class="text-danger">{{number_format($product->price,0, ',', ' '). ' '.__('Sum')}}</del></span>
                                                                        @else
                                                                            <span class="price">{{number_format($product->price,0, ',', ' '). ' '.__('Sum')}}</span>
                                                                        @endif
                                                                        <div class="cart=btn mt-10 d-lg-flex">
                                                                            <a class="rounded main-btn single-product-tag-show-modal" href="#" data-toggle="modal"  data-id="{{$product->id}}" ><i class="lni lni-eye"></i></a>
                                                                            <a class="rounded my-sm-1 my-lg-0 mx-lg-1 mx-sm-0  main-btn add-wishlist @if(inWish($product->id)) bg-danger border-0 active @endif " data-id="{{$product->id}}" href="#"><i class="lni lni-heart"></i> {{__('web.Wishlist')}}</a>
                                                                            <a class="rounded main-btn border-0 @if(inCart($product->id)) bg-success @endif add-to-cart" data-id="{{$product->id}}" href="#"><i class="lni lni-cart-full"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- product card -->
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div> <!-- product list -->
                                    </div>
                                </div> <!-- tab content -->
                            </div> <!-- shop product -->
                        </div> <!-- category product -->
                    </div>
                </div> <!-- row -->
            @else
                <div class="d-flex">
                    <div class="rounded border border-info w-50">
                        <img src="{{Voyager::image('5ac049c882336e2719661060f4d2ce69.jpg')}}" />
                        <div class="position-absolute" style="top: 50%; right: 25%">
                            <a class="main-btn rounded" href="{{url('/')}}"><i class="fad fa-home-lg "></i> {{__('GO TO HOME')}}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div> <!-- container -->
    </section>

    <!--====== CATEGORY PAGE PART ENDS ======-->
@endsection
@push( 'scripts')

@endpush



