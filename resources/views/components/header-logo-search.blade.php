<div class="header-logo-search d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header-logo">
                    <a href="{{url('/')}}">
                        <img src="{{ asset('storage/logo/logo-final.svg') }}" alt="Logo">
                    </a>
                </div> <!-- header logo -->
            </div>
            <div class="col-lg-9">
                <div class="header-search-shop-cart  d-flex justify-content-between">
                    <div class="header-search d-flex">
                        <div class="search-categories" >
                            <div class="categories-dropdown" >
                                <div class="cate-toggler" style="cursor: help !important;" >
                                    <label for="search_input">
                                        <i class="fad fa-search"></i>
                                    </label>
                                </div>
                            </div> <!-- categories dropdown -->
                        </div> <!-- search categories -->
                        <div class="search-form">
                            <form action="#" class="d-flex">
                                <input id="search_input" type="text" placeholder="{{__('web.Search here...')}}">
                                <button>{{ __('web.Search')}}</button>
                            </form>
                        </div>
                    </div> <!-- header search -->
                    <div class="header-shop-cart">
                        <ul>
                            <li>
                                <a class="single-cart" href="{{route('my.cabinet.wishlist')}}" data-toggle="tooltip" data-placement="top" title="{{ __('web.Wishlist') }}">
                                    <i class="fas fa-heart-circle" style="font-size: 22px"></i>
                                    <span class="shop-quantity wishlist-box">{{$wishlist_count}}</span>
                                </a>
                            </li>
                            <li>
                                <a class="single-cart" href="{{route('view.cart')}}" data-toggle="tooltip" data-placement="top" title="{{ __('web.Cart') }}">
                                            <span class="cart">
                                               <i class="fad fa-shopping-cart" style="font-size: 20px"></i>
                                                <span class="shop-quantity shop-quantity-box" >{{$cart_amount}}</span>
                                            </span>
                                </a>
                            </li>
                        </ul>
                    </div> <!-- header shop cart -->
                </div> <!-- header search shop cart -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- header logo search -->
