@extends("layouts.master")
@section('title', __('web.Login'))
@section("content")
    <header>
        @include('components.top-header')
        @include('components.header-logo-search')
        @include('components.menu')
    </header>
    <!--====== LOGIN PART START ======-->
    @include( 'components.mobile-menu')
    <section class="login-area pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9 col-sm-11">
                    <div class="login-wrapper box_shadow rounded">
                        <div class="section-title text-center">
                            <h3 class="title">{{ __('web.Login') }}</h3>
                            <p class="text pt-10"> {{ __('web.Please Login using account detail bellow') }}.</p>
                        </div> <!-- section title -->
                        <div class="login-form">
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="single-form clearfix form-group">
                                    <label for="phone">{{ __('web.Phone') }}</label>
                                    <input type="text" required name="phone" class="form-control rounded @error('phone') is-invalid @enderror" id="phone" placeholder="{{ __('web.Enter your phone number') }} * " autocomplete="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <label class="text-danger" role="alert">
                                            <i class="fad fa-exclamation-triangle"></i> <strong> {{ $message }} </strong>
                                        </label>
                                    @enderror
                                </div> <!-- single form -->

                                <div class="single-form clearfix form-group">
                                    <label for="password">{{ __('web.Password') }}</label>
                                    <input type="password" required name="password" class="form-control rounded @error('password') is-invalid @enderror" id="password" placeholder="{{ __('web.Enter your password') }} * ">
                                    @error('password')
                                        <label class="text-danger">
                                            <i class="fad fa-exclamation-triangle"></i> <strong> {{ $message }} </strong>
                                        </label>
                                    @enderror
                                </div> <!-- single form -->
                                <div class="login-check-forget d-sm-flex justify-content-between">
                                    <div class="check mt-10">
                                        <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember">{{ __('web.Remember me') }}</label>
                                    </div>
                                    <div class="forget mt-10">
                                        @if (Route::has('password.request'))
                                            <a class="" href="#">
                                                {{ __('web.Forgot your password') }}
                                            </a>
                                        @endif
                                    </div>
                                </div> <!-- single form -->
                                <div class="single-form clearfix">
                                    <button class="main-btn float-right rounded" type="submit">{{ __('web.Login') }}</button>
                                </div> <!-- single form -->
                            </form>
                        </div> <!-- tracking title -->
                    </div> <!-- ordear tracking wrapper -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== LOGIN PART ENDS ======-->
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
            color: #dadae5;
            opacity: 1;
        }
        input#password::placeholder {
            color: #dadae5;
            opacity: 1;
        }
    </style>
@endpush
