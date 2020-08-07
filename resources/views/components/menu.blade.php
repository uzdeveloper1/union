<div class="header-menu-area d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-2 sticky-block">
                <div class="menu-logo">
                    <a href="{{url('/')}}"><img src="{{ asset('storage/logo/logo-final.svg') }}"  alt="Logo"></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="navbar-menu">
                    <ul>
                        <li>
                            <a class="@if (Request::is('/'))
                                active
                            @endif" href="{{url('/')}}">{{__('web.Home')}}</a>
                        </li>
                        <li><a href="#">{{__('web.Categories')}}</a>
                            <ul class="mega-menu clearfix rounded">
                                @foreach($categories as $category)
                                    <li class="my-3">
                                        <h5 class="menu-title">{{ $category->getTranslatedAttribute('name') }}</h5>
                                        @if ($category->children !== null)
                                            @foreach($category->children as $children)
                                                @include( 'components.children-categories' , ['children' => $children])
                                            @endforeach
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a class="@if (Request::is('about*'))
                            active
                        @endif" href="{{route('about')}}">{{__('web.About us')}}</a></li>
                        <li><a @if(Request::is('blog*')) active @endif href="#">{{__('web.Blog')}}</a>
                            <ul class="sub-menu">
                                @isset($post_categories)
                                    @if ($post_categories !== null)
                                        @foreach($post_categories as $post_category)
                                            <li><a href="{{route('post.by.category', ['category' => $post_category])}}">{{$post_category->getTranslatedAttribute('name')}}</a></li>
                                        @endforeach
                                    @endif
                                @endisset
                            </ul>
                        </li>
                        <li><a class="@if(Request::is('contact*')) active @endif" href="{{route('contact')}}">{{__('web.Contact')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 sticky-block">
                <div class="header-shop-cart">
                    <ul>
                        <li>
                            <a class="single-cart" href="{{route('my.cabinet.wishlist')}}">
                                <i class="lni lni-heart"></i>
                                <span class="shop-quantity wishlist-box">{{$wishlist_count}}</span>
                            </a>
                        </li>
                        <li>
                            <a class="single-cart" href="{{route('view.cart')}}">
                                <span class="cart">
                                    <i class="lni lni-cart"></i>
                                    <span class="shop-quantity shop-quantity-box">{{$cart_amount}}</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div> <!-- header shop cart -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- header menu area -->

<div class="header-mobile-menu d-lg-none">
    <div class="container">
        <div class="mobile-menu d-flex justify-content-between align-items-center">
            <div class="menu-bar">
                <a class="mobile-menu-open" href="javascript:void(0)"><i class="lni lni-menu"></i></a>
            </div>
            <div class="mobile-logo">
                <a href="{{url('/')}}"><img src="{{ asset('storage/logo/logo-final.svg') }}" height="60" alt="Logo"></a>
            </div> <!-- mobile logo -->
            <div class="header-shop-cart">
                <ul>
                    <li>
                        <a class="single-cart" href="{{route('my.cabinet.wishlist')}}">
                            <i class="lni lni-heart"></i>
                            <span class="shop-quantity wishlist-box">{{$wishlist_count}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="single-cart" href="#">
                            <span class="cart">
                                <i class="lni lni-cart"></i>
                                <span class="shop-quantity shop-quantity-box">{{$cart_amount}}</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div> <!-- header shop cart -->
        </div> <!-- mobile menu -->
    </div> <!-- container -->
</div> <!-- header mobile menu -->
