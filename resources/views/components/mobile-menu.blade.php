<div class="offcanvas-menu-wrapper">
    <div class="offcanvas-menu">
        <a class="close-mobile-menu" href="javascript:void(0)"><i class="lni lni-close"></i></a>
        <div class="mobile-menu pt-30">
            <nav>
                <ul>
                    <li class="menu-item-has-children">
                        <a class="@if (Request::is('/'))
                            active
                        @endif" href="{{url('/')}}">{{__('web.Home')}}</a>
                    </li>
                    <li class="menu-item-has-children"><a href="#" class="@if( Request::is('category*') ) active @endif">{{__('web.Categories')}}</a>
                        <ul class="sub-menu">
                            @foreach($categories as $category)
                                <li class="mega-title menu-item-has-children">
                                    <a href="#" >{{ $category->getTranslatedAttribute('name') }}</a>
                                    <ul class="sub-menu">
                                        @if ($category->children !== null)
                                            @foreach($category->children as $children)
                                                <li><a class="@if( Request::is('category/'.$children->id.'/products') ) active @endif" href="{{route('category.products', ['category' => $children->id])}}">{{ $children->getTranslatedAttribute('name')}}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a class="@if (Request::is('about*'))
                            active
                        @endif"
                           href="{{route('about')}}">
                            {{__('web.About us')}}
                        </a>
                    </li>
                    <li class="menu-item-has-children"><a class="@if( Request::is('posts*') ) active @endif" href="#">{{__('web.Blog')}}</a>
                        <ul class="sub-menu">
                            @isset($post_categories)
                                @if ($post_categories !== null)
                                    @foreach($post_categories as $post_category)
                                        <li><a class="@if( Request::is('posts/category-posts/'. $post_category->id) ) active @endif" href="{{route('post.by.category', ['category' => $post_category])}}">{{$post_category->getTranslatedAttribute('name')}}</a></li>
                                    @endforeach
                                @endif
                            @endisset
                        </ul>
                    </li>
                    <li><a class="@if( Request::is('contact*') ) active @endif" href='{{route('contact')}}'>{{__('web.Contact')}}</a></li>
                </ul>
            </nav>
        </div>
        <div class="">
            <img src="{{asset('storage/logo/logo-final.svg')}}" class="img-fluid w-100" alt="logo union">
        </div>
    </div>
    <div class="overlay"></div>
</div>

