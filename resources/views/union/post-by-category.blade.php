@extends( "layouts.master" )
@section('title', $category->getTranslatedAttribute('name'))
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
    <section class="blog-area pt-70 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center pb-20">
                        <h3 class="title">{{$category->getTranslatedAttribute('name')}}</h3>
                        <span class="line"></span>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-7">
                        <div class="single-blog mt-30 rounded">
                            <div class="blog-image rounded">
                                <img class="rounded" src="{{Voyager::image($post->image)}}" alt="Union Blog image">
                            </div>
                            <div class="blog-content rounded">
                                <span class="date rounded">{{$post->created_at}}</span>
                                <h4 class="blog-title"><a href="{{route('single.post', ['post' => $post])}}">{{$post->getTranslatedAttribute('title')}}</a></h4>
                                <a href="{{route('single.post', ['post' => $post])}}" class="more rounded">{{__('Read More')}}</a>
                            </div>
                        </div> <!-- single blog -->
                    </div>
                @endforeach
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
@endsection
@push( 'scripts')

@endpush



