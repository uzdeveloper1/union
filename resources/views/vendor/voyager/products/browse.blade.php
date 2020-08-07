
@extends('voyager::master')
@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
{{--        @include('voyager::multilingual.language-selector')--}}
    </div>
@stop
@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
{{--                        @dump($dataType->browseRows)--}}
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                        <th>{{$row->getTranslatedAttribute('display_name')}}</th>
                                    @endforeach
                                    <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if (isset($products))
                                            @foreach($products as $product)
                                                <tr>
                                                    @foreach($dataType->browseRows as $row)
                                                        <td>{{ $product->{$row->field} }}</td>
                                                    @endforeach
                                                        <td class="no-sort no-click bread-actions">
                                                            <a href="javascript:;" title="{{__('voyager::generic.delete')}}" class="btn btn-sm btn-danger pull-right delete" data-id="{{$product->id}}" id="delete-{{$product->id}}">
                                                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{__('voyager::generic.delete')}}</span>
                                                            </a>
                                                            <a href="{{ route('voyager.products.edit', ['id' => $product->id]) }}" title="{{__('voyager::generic.edit')}}" class="btn btn-sm btn-primary pull-right edit">
                                                                <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">{{__('voyager::generic.edit')}}</span>
                                                            </a>
                                                            <a href="{{ route('voyager.products.show', ['id'=>$product->id]) }}" title="{{__('voyager::generic.browse')}}" class="btn btn-sm btn-warning pull-right view">
                                                                <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">{{__('voyager::generic.browse')}}</span>
                                                            </a>
                                                        </td>
                                                </tr>
                                            @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                        array_merge([
                            "order" => 1,
                            "language" => __('voyager::datatable'),
                            "columnDefs" => [['targets' => -1, 'searchable' =>  false, 'orderable' => false]],
                        ],
                        config('voyager.dashboard.data_tables', []))
                    , true) !!});
            @else
            $('#search-input select').select2({
                minimumResultsForSearch: Infinity
            });
            @endif

            @if ($isModelTranslatable)
            $('.side-body').multilingual();
            //Reinitialise the multilingual features when they change tab
            $('#dataTable').on('draw.dt', function(){
                $('.side-body').data('multilingual').init();
            })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });



    </script>
@stop

