@extends("layouts.master")
@section('title', __('web.Register'))
@section("content")
    <header>
        @include('components.top-header')
        @include('components.header-logo-search')
        @include('components.menu')
    </header>
    @include( 'components.mobile-menu')
    <!--====== REFISTER PART START ======-->
    <section class="login-area pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9 col-sm-11">
                    <div class="login-wrapper box_shadow rounded">
                        <div class="section-title text-center">
                            <h3 class="title">{{ __('web.Register') }}</h3>
                        </div> <!-- section title -->
                        <div class="login-form">
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                @method('POST')
                                <!-- single form -->
                                <div class="single-form clearfix form-group">
                                    <input type="text" required name="name" class="form-control rounded" id="name" placeholder="{{ __('web.Name') }} * " autocomplete="phone" value="{{ old('name') }}">
                                    @error('name')
                                        <label class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>

                                <div class="single-form clearfix form-group">
                                    <input type="text" required name="phone" class="form-control rounded" id="phone" placeholder="{{ __('web.Phone') }} * " autocomplete="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <label class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>

                                <div class="single-form clearfix form-group">
                                    <input type="email" name="email" class="form-control rounded" id="email" placeholder="{{ __('web.Email') }} " autocomplete="phone" value="{{ old('email') }}">
                                    @error('email')
                                        <label class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>

                                <div class="single-form clearfix form-group">
                                    <input type="password" required  name="password" class="form-control rounded" id="password" placeholder="{{ __('web.Password') }} * ">
                                    @error('password')
                                        <label class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>

                                <div class="single-form clearfix form-group">
                                    <input type="password" required  name="password_confirmation" class="form-control rounded" id="password_confirmation" placeholder="{{ __('web.Password Confirm') }} * ">
                                    @error('password_confirmation')
                                        <label class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
                                <div class="single-form clearfix">
                                    <button class="main-btn float-right rounded" type="submit">{{ __('web.Register') }}</button>
                                </div> <!-- single form -->
                            </form>
                        </div> <!-- tracking title -->
                    </div> <!-- ordear tracking wrapper -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== REGISTER PART ENDS ======-->
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src=" {{ asset('union/assets/js/vendor/jquery.inputmask.min.js') }} "></script>
    <script>
        $(document).ready(function () {
            $('#phone').inputmask({
                showMaskOnFocus: false,
                showMaskOnHover: false,
                showMaskOnChange : true,
                colorMask: true,
                alias: 'phone',
                mask: '+\\9\\98999999999',

            }).on('focus', function () {
                $(this).attr('placeholder', '+998998888888')
            });
        });
    </script>
@endpush
@push('css')
    <style>
        input#phone::placeholder {
            color: #ababb8;
            opacity: 1;
        }
        input#password::placeholder {
            color: #ababb8;
            opacity: 1;
        }
        input#email::placeholder {
            color: #ababb8;
            opacity: 1;
        }
        input#name::placeholder {
            color: #ababb8;
            opacity: 1;
        }
        input#password_confirmation::placeholder {
            color: #ababb8;
            opacity: 1;
        }
    </style>
@endpush

