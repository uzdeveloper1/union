@extends( "layouts.master" )
@section('title', __('web.Cart'))
@push('css')
    <link rel="stylesheet" href="{{asset('css/jquery.bootstrap-touchspin.min.css')}}">
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
                        <a class="nav-link mb-3 p-3 shadow "  href="{{route('my.cabinet.info')}}">
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

                        <a class="nav-link mb-3 p-3 shadow active"  href="{{route('view.cart')}}">
                            <i class="fad fa-box-full mr-2"></i>
                            <span class="font-weight-bold small text-uppercase">{{__('web.Cart')}}</span>
                        </a>
                    </div>
                </div>


                <div class="col-md-9">
                    <!-- Tabs content -->
                    <div class="tab-content">
                        <div class="tab-pane show active fade shadow rounded bg-white p-5">
                            <h4 class="font-italic mb-4 text-center">{{__('web.Cart')}}</h4>
                            @if($cart_items !== null)
                                @if($cart_items->count() > 0)
                                    <div class="row bg-white rounded shadow-sm mb-5">
                                        <!-- Shopping cart table -->
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="border-0 py-2 bg-light">
                                                        <div class="p-2 px-3 text-uppercase">{{__('web.Product')}}</div>
                                                    </th>
                                                    <th scope="col" class="border-0  py-2  bg-light">
                                                        <div class="text-center  text-uppercase">{{__('web.PRICE')}}</div>
                                                    </th>
                                                    <th scope="col" class="border-0  py-2 bg-light">
                                                        <div class="text-center text-uppercase">{{__('web.Quantity')}}</div>
                                                    </th>
                                                    <th colspan="2" scope="col" class="border-0  py-2 bg-light">
                                                        <div class="text-center text-uppercase">{{__('web.Total amount')}}</div>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($cart_items as $cart_item)
                                                    <tr class="">
                                                        <th scope="row" class="border-0">
                                                            <div class="p-2">
                                                                <a href="{{route('single.product', ['id' => $cart_item->id])}}">
                                                                    <img src="{{Voyager::image($cart_item->image[0])}}" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                                </a>
                                                                <div class="ml-3 d-inline-block align-middle">
                                                                    <h5 class="mb-0"> <a href="{{route('single.product', ['id' => $cart_item->id])}}" class="text-dark d-inline-block align-middle">{{$cart_item->getTranslatedAttribute('name')}}</a></h5>
                                                                    <a href="{{route('category.products', ['category' => $cart_item->category->id])}}">
                                                                        <span class="text-muted font-weight-normal font-italic d-block">{{__('web.Category')}} : {{$cart_item->category->getTranslatedAttribute('name')}}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="border-0 align-middle text-center"><strong>{{number_format($cart_item->price,0, ',', ' ').' '. __('sum')}}</strong>@if($cart_item->old_price)<br><del class="text-danger">{{number_format($cart_item->old_price,0, ',', ' ').' '. __('sum')}}</del>@endif</td>
                                                        <td class="border-0 align-middle text-center"><input readonly style="width: 80px !important;" value="{{$cart_item->pivot['quantity']}}" data-id="{{$cart_item->id}}" type="number" class="product-touch"></td>
                                                        <td class="border-0 align-middle text-center"><strong>{{number_format($cart_item->item_total_sum,0, ',', ' ').' '. __('sum')}}</strong></td>
                                                        <td class="border-0 align-middle text-center px-2"><button  data-id="{{$cart_item->id}}" class="text-dark border-0 delete bg-light"><i class="fad fa-trash-alt"></i></button></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End -->
                                    </div>
                                    <div class="row py-5 p-4 bg-white rounded shadow-sm">
                                        <div class="col-lg-12">
                                            <div class="bg-light rounded px-4 py-3 text-uppercase font-weight-bold">{{__('web.Sum of orders')}}</div>
                                            <div class="p-4">
                                                <ul class="list-unstyled mb-4">
                                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">{{__('web.Order Subtotal')}} : </strong><strong>{{number_format($sum_of_cart,0, ',', ' ').' '. __('sum')}}</strong></li>
                                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">{{__('web.Discount')}} : </strong><strong>{{number_format($sum_of_discount,0, ',', ' ').' '. __('sum')}}</strong></li>
                                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">{{__('web.Delivery cost')}} : </strong><strong>{{number_format($delivery_price,0, ',', ' ').' '. __('sum')}}</strong></li>
                                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">{{__('web.Total payable')}} : </strong>
                                                        <h5 class="font-weight-bold">{{number_format($sum_of_payment,0, ',', ' ').' '. __('sum')}}</h5>
                                                    </li>
                                                </ul><a href="#" class="btn btn-dark rounded py-2 btn-block">{{__('web.Checkout')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center my-3">
                                        <h3 class="text-center">{{__('web.In your cart is empty')}} !</h3>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <a class="main-btn rounded" href="{{url('/')}}">{{__('web.Go to shopping')}}</a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center my-3">
                                    <h3 class="text-center">{{__('web.In your cart is empty')}} !</h3>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a class="main-btn rounded" href="{{url('/')}}">{{__('web.Go to shopping')}}</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-footer">
                    <form action="{{route('delete.cart.item')}}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <form action="{{route('edit.cart.item')}}" id="edit_form" method="POST" class="d-none">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <input type="hidden" name="quantity" value="">
    </form>
@endsection
@push('scripts')
    <script src="{{asset('js/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script>
        let i = $("input[class='product-touch']");
        i.TouchSpin({
            verticalbuttons: true,
            min:1,
            max:null,
            verticalup: '<i class="far fa-plus-square"></i>',
            verticaldown: '<i class="far fa-minus-square"></i>'
        });
        let editFormAction;
        i.on("touchspin.on.startspin", function() {
            var formEdit = $('#edit_form')[0];
            if (!editFormAction) {
                // Save form action initial value
                editFormAction = formEdit.action;
            }
            formEdit['quantity'].value = $(this).val();
            formEdit.action = editFormAction.match(/\/[0-9]+$/)
                ? editFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : editFormAction + '/' + $(this).data('id');
            formEdit.submit();
        });
    </script>
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];
            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });

    </script>
@endpush
