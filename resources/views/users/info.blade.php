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
                        <a class="nav-link mb-3 p-3 shadow active"  href="{{route('my.cabinet.info')}}">
                            <i class="fad fa-user mr-2 "></i>
                            <span class="font-weight-bold small text-uppercase">{{__('web.Personal information')}}</span>
                        </a>

                        <a class="nav-link mb-3 p-3 shadow" href="{{route('my.cabinet.wishlist')}}">
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
                            <h4 class="font-italic mb-4 text-center">{{__('web.Personal information')}}</h4>
                            <div class="row">
                                <div class="col-xl-12">
                                    <form method="post" action="{{route('user.update', ['user' => $user])}}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="staticPhone" class="col-md-5 col-form-label">{{__('web.Phone')}}</label>
                                            <div class="col-md-7">
                                                <input type="text"  readonly class="form-control-plaintext" id="staticPhone" value="{{$user->phone}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-md-5 col-form-label">{{__('web.Name')}}</label>
                                            <div class="col-md-7">
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="{{__('web.Name')}}" value="{{old('name', $user->name)}}">
                                                @error('name')
                                                    <label class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-md-5 col-form-label">{{__('web.Email')}}</label>
                                            <div class="col-md-7">
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="{{__('web.Email')}}" value="{{old('email', $user->email)}}">
                                                @error('email')
                                                    <label class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <h4 class="text-center">{{__('web.Edit Password')}}</h4>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputOldPass" class="col-md-5 col-form-label">{{__('web.Old Password')}}</label>
                                            <div class="col-md-7">
                                                <input type="password" name="old_password" class="form-control @if ($message = Session::get('old_password_error')) is-invalid @endif" id="inputOldPass" placeholder="{{__('web.Old Password')}}">
                                                @if ($message = Session::get('old_password_error'))
                                                    <label class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputNewPass" class="col-md-5 col-form-label">{{__('web.New Password')}}</label>
                                            <div class="col-md-7">
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputNewPass" placeholder="{{__('web.New Password')}}">
                                                @error('password')
                                                    <label class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPassConfirm" class="col-md-5 col-form-label">{{__('web.Password Confirm')}}</label>
                                            <div class="col-md-7">
                                                <input type="password" name="password_confirmation" class="form-control" id="inputPassConfirm" placeholder="{{__('web.Password Confirm')}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="main-btn rounded float-right">{{__('web.Save')}}</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
