@extends( "layouts.master" )
@section('title', $post->getTranslatedAttribute('title'))
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
    <section class="blog-details-page pt-50 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-content mt-30 pb-30">
                        <div class="details-image">
                            <img src="{{Voyager::image($post->image)}}" alt="blog Details">
                        </div> <!-- details image -->
                        <div class="details-content mt-25">
                            <h3 class="blog-title">{{$post->getTranslatedAttribute('title')}}</h3>
                            <ul class="blog-meta">
                                <li><a href="#"><i class="lni lni-calendar"></i> {{$post->created_at}} </a></li>
                            </ul>

                        <div class="row">
                            <div class="col-12">
                                {!! $post->body !!}
                            </div>
                        </div>

                        </div>
                    </div> <!-- blog details content -->
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar mt-30">
                        <div class="sidebar-post">
                            <div class="sidebar-title">
                                <h4 class="title">{{__('RECENT POSTS')}}</h4>
                            </div>
                            <div class="post-list pt-10">
                                <ul>
                                    @foreach($latest_posts as $item)
                                        <li>
                                            <div class="single-sidebar-post d-flex">
                                                <div class="post-image">
                                                    <a href="{{route('single.post', ['post' => $item ])}}"><img src="{{Voyager::image($item->image)}}" alt="Post"></a>
                                                </div>
                                                <div class="post-content media-body">
                                                    <h5 class="post-title"><a href="#">{{$item->getTranslatedAttribute('title')}}</a></h5>
                                                    <span><i class="lni lni-calendar"></i> {{$item->created_at}}</span>
                                                </div>
                                            </div> <!-- single sidebar post -->
                                        </li>
                                    @endforeach
                                </ul>
                            </div> <!-- post list -->
                        </div> <!-- sidebar post -->
                    </div> <!-- blog sidebar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
@endsection
@push( 'scripts')

@endpush



