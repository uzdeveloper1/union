@extends( "layouts.master" )
@section('title', config('app.name').'.uz')
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

    <!--====== SLIDER PART START ======-->
    @include( 'components.slider', ['banners'=>$banners])

    <!--====== SLIDER PART ENDS ======-->

    <!--====== FEATURE CATEGORIES PART START ======-->

    <section class="feature-categories-area pt-50">
        <div class="container">
            <div class="row">
{{--                @dd($feature_categories)--}}
                @if ($feature_categories->count() > 0 && $feature_categories !== null)
                    @foreach($feature_categories as $feature_category)
                        <div class="col-lg-4 col-sm-6">
                            <div class="single-feature-categories rounded mt-30">
                                <div class="feature-categories-image">
                                    <img class="rounded" src="{{Voyager::image($feature_category->image)}}" alt="feature categories">
                                </div>
                                <div class="feature-categories-content text-center rounded">
                                    <div class="categories-content rounded">
                                        <h3 class="categories-title">{{$feature_category->getTranslatedAttribute('name')}}</h3>
                                        <p class="text">{{$feature_category->getTranslatedAttribute('description')}}</p>
                                    </div>
                                    <div class="categories-btn rounded">
                                        <a class="main-btn rounded" href="{{route('category.products', ['category' => $feature_category->id])}}">{{__('web.Shop Now')}}</a>
                                    </div>
                                </div>
                            </div> <!-- single feature categories -->
                        </div>
                    @endforeach
                @endif
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== FEATURE CATEGORIES PART ENDS ======-->
    <!--====== NEW ARRIVALS PART START ======-->
@if(isset($new_products_categories) && !empty($new_products_categories))
    <section class="new-arrivals-area pt-70 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title pb-20">
                        <h3 class="title">{{__('web.New Arrivals')}}</h3>
                        <span class="line"></span>
                        <a class="float-right " href="{{route('new.products')}}">{{__('web.Show more')}}</a>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row">
                @foreach($new_products_categories as $new_products)
                    @foreach($new_products->products as $new_product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product-card text-center mt-30 rounded">
                                <div class="product-image rounded">
                                    <img class="rounded" src="{{Voyager::image($new_product->image[0])}}" alt="product">
                                    @if ($new_product->new === 1 )
                                        <div class="sticker new">
                                            <span>{{__('web.New')}}</span>
                                        </div>
                                    @endif
                                    @if($new_product->discount === 1)
                                        <div class="sticker discount">
                                            <span>-{{$new_product->discount_percent}}%</span>
                                        </div>
                                    @endif

                                </div>
                                <div class="product-content rounded">
                                    <h5 class="product-name"><a href="{{route('single.product', ['id' => $new_product->id])}}">{{$new_product->getTranslatedAttribute('name')}}</a></h5>

                                    @if($new_product->discount === 1)
                                        <span class="price">{{number_format($new_product->discount_price,0, ',', ' '). ' '.__('Sum')}}</span>
                                        <span class="price text-danger"><del class="text-danger">{{number_format($new_product->price,0, ',', ' '). ' '.__('Sum')}}</del></span>
                                    @else
                                        <span class="price">{{number_format($new_product->price,0, ',', ' '). ' '.__('Sum')}}</span>
                                    @endif
                                    <ul class="actions">
                                        <li ><a class="rounded single-product-tag-show-modal" href="#" data-toggle="modal"  data-id="{{$new_product->id}}" ><i class="lni lni-eye"></i></a></li>
                                        <li><a class="rounded add-wishlist @if(inWish($new_product->id)) bg-danger border-0 active @endif " href="#" data-id="{{$new_product->id}}"><i class="lni lni-heart"></i></a></li>
                                        <li><a class="rounded add-to-cart border-0 @if(inCart($new_product->id)) bg-success @endif" href="#" data-id="{{$new_product->id}}"><i class="lni lni-cart-full"></i></a></li>
                                    </ul>
                                </div>
                            </div> <!-- product card -->
                        </div>
                    @endforeach
                @endforeach
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
@endif
    <!--====== NEW ARRIVALS PART ENDS ======-->

    <!--====== BLOG PART START ======-->
    <section class="blog-area pt-70 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title  pb-20">
                        <h3 class="title">{{__('web.Our Blog')}}</h3>
                        <span class="line"></span>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                @foreach($latest_blog as $post)
                    <div class="col-lg-4 col-md-7">
                        <div class="single-blog mt-30">
                            <div class="blog-image">
                                <img src="{{ Voyager::image($post->image) }}" alt="Blog">
                            </div>
                            <div class="blog-content">
                                <span class="date rounded">{{$post->created_at}}</span>
                                <h4 class="blog-title"><a href="{{route('single.post', ['post' => $post->id])}}">{{$post->getTranslatedAttribute('title')}}</a></h4>
                                <p class="text">{{Str::limit($post->getTranslatedAttribute('excerpt'), 100)}}</p>
                                <a href="{{route('single.post', ['post'=>$post->id])}}" class="more rounded">{{__('web.Read More')}}</a>
                            </div>
                        </div> <!-- single blog -->
                    </div>
                @endforeach
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== BLOG PART ENDS ======-->
    @if (setting('site.partners') && $partners->count() > 0)
        <!--====== CLIENT LOGO PART START ======-->
        <section class="blog-area pt-70 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center pb-20">
                            <h3 class="title">{{ __('web.Partners') }}</h3>
                            <span class="line"></span>
                        </div> <!-- section title -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </section>
        <div class="client-logo client-logo-bg pt-80 pb-55">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="client-logo-active">
                            @foreach( $partners as  $partner)
                                <div class="single-client-logo">
                                    <a href="{{ $partner->url }}">
                                        <img src="{{ asset('storage/'.str_replace('\\', '/', $partner->image)) }}" alt="client Logo">
                                    </a>
                                </div>
                            @endforeach

                        </div> <!-- client logo active -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>

        <!--====== CLIENT LOGO PART ENDS ======-->
    @endif


    <!--====== SUPPORT PART START ======-->

    <div class="support-area pt-50 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single-support mt-30 rounded">
                        <i class="lni lni-plane"></i>
                        <p class="text">Free Shipping Worldwide </p>
                    </div> <!-- single support -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-support mt-30 rounded">
                        <i class="lni lni-headphone-alt"></i>
                        <p class="text">24/7 Customer Service </p>
                    </div> <!-- single support -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-support mt-30 rounded">
                        <i class="lni lni-reload"></i>
                        <p class="text">Easy Return Policy</p>
                    </div> <!-- single support -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div>

    <!--====== SUPPORT PART ENDS ======-->

@endsection
@push( 'scripts')

@endpush

