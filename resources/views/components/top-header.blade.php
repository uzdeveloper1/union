@push('css')
    <style>
        #lang_selector{
            height: 0 !important;
            line-height: 0 !important;
        }
        #lang_selector::before{
            position: absolute;
            content: '';
            width: 0;
            height: 0;
            background-color: transparent;
            top: 0;
            right: 0;
        }
    </style>
@endpush
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header-top-content d-sm-flex justify-content-between">
                    <div class="header-info text-center">
                        <p>{{__('web.Phone')}} :  {{setting('site.phone')}}</p>
                    </div>
                    <div class="header-info text-center">
                        <div class="search-categories border-0">
                            <div class="categories-dropdown">
                                <div class="cate-toggler border-0" id="lang_selector">
                                    @php
                                        $locale = Session::get('locale');
                                    @endphp
                                    @if ( $locale === 'uz-latin')
                                        <span class="text-uppercase"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_Uzbekistan.svg') }}" alt="uz-latin-flag">  UZB</span>
                                    @elseif ( $locale === 'uz-cyrillic')
                                        <span class="text-uppercase"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_Uzbekistan.svg') }}" alt="uz-latin-flag">  Ўзб</span>
                                    @elseif( $locale === 'ru')
                                        <span class="text-uppercase"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_Russia.svg') }}" alt="uz-latin-flag">  RUS</span>
                                    @else
                                        <span class="text-uppercase"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_the_United_Kingdom.svg') }}">  ENG</span>
                                    @endif
                                        <i class="lni lni-chevron-down"></i>
                                </div>
                                <ul class="cate-dropdown-menu w-100 rounded" style="display: none">
                                    <li class="p-1 d-flex justify-content-start text-uppercase"><a href="{{ url('locale/uz-latin') }}"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_Uzbekistan.svg') }}">  UZB</a></li>
                                    <li class="p-1 d-flex justify-content-start text-uppercase"><a href="{{ url('locale/uz-cyrillic') }}"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_Uzbekistan.svg') }}">  Ўзб</a></li>
                                    <li class="p-1 d-flex justify-content-start text-uppercase"><a href="{{ url('locale/ru') }}"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_Russia.svg') }}">  RUS</a></li>
                                    <li class="p-1 d-flex justify-content-start text-uppercase"><a href="{{ url('locale/en') }}"><img width="30px" src="{{ asset('union/assets/flags/Flag_of_the_United_Kingdom.svg') }}">  ENG</a></li>
                                </ul>
                            </div> <!-- categories dropdown -->
                        </div> <!-- search categories -->
                    </div>
                    <div class="header-info text-center">
                        <ul class="header-info-block">
                            @if (!Auth::check())
                                <li class="header-info-item"><a href="{{ route('login') }}"><i class="fad fa-user" style="font-size: 20px"></i> {{__('web.Login')}} </a></li>
                                <li class="header-info-item"><a href="{{route('register')}}">{{__('web.Register')}}</a></li>
                            @else
                                <li class="header-info-item"><a href="{{route('my.cabinet.info')}}"><i class="fad fa-user" style="font-size: 20px"></i> {{Auth::user()->name}} </a></li>
                                <li class="header-info-item"><a href="#">{{__('web.Checkout')}}</a></li>
                                <li class="header-info-item"><a href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('web.Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div> <!-- header top -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- header top -->
