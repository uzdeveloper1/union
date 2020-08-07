
@extends( 'voyager::master')
@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
{{--    @include('voyager::multilingual.language-selector')--}}
@stop
@section( 'content')
    <form role="form"
          class="form-edit-add"
          action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', ['id' => 1]) : route('voyager.'.$dataType->slug.'.store') }}"
          method="POST" enctype="multipart/form-data">
        <!-- PUT Method if we are editing -->
    @if($edit)
        {{ method_field("PUT") }}
    @endif

    <!-- CSRF TOKEN -->
        {{ csrf_field() }}

        <div class="panel-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
{{--            @dump($dataType->addRows)--}}
                @php
                    $name           = $dataType->addRows->where('field', 'name')->first();
                    $name_lang      = $name->getTranslatedAttribute('display_name');
                    $slug           = $dataType->addRows->where('field', 'slug')->first();
                    $model          = $dataType->addRows->where('field', 'model')->first();
                    $category_id    = $dataType->addRows->where('field', 'category_id')->first();
                    $image          = $dataType->addRows->where('field', 'image')->first();
                    $description    = $dataType->addRows->where('field', 'description')->first();
                    $desc_lang      = $description->getTranslatedAttribute('display_name');
                    $brand_id       = $dataType->addRows->where('field', 'brand_id')->first();
                    $price          = $dataType->addRows->where('field', 'price')->first();
                    $discount_price = $dataType->addRows->where('field', 'discount_price')->first();
                    $active         = $dataType->addRows->where('field', 'active')->first();
                    $new            = $dataType->addRows->where('field', 'new')->first();
                    $new_start      = $dataType->addRows->where('field', 'new_start')->first();
                    $new_end        = $dataType->addRows->where('field', 'new_end')->first();
                    $discount       = $dataType->addRows->where('field', 'discount')->first();
                    $discount_start = $dataType->addRows->where('field', 'discount_start')->first();
                    $discount_end   = $dataType->addRows->where('field', 'discount_end')->first();

                @endphp
{{--                Start name--}}
            {{-- en --}}
                <div class="form-group">
                    <label for="{{ $name->field }}">{{ $name_lang.' EN '}}</label>
                    <input type="text" class="form-control" name="{{ $name->field }}" id="{{ $name->field }}" @if ($name->required === 1) required @endif value="{{ old($name->field) }}">
                </div>
            {{-- end en --}}

            {{-- ru--}}
                <div class="form-group">
                    <label for="{{ $name->field.'ru' }}">{{ $name_lang.' RU '}}</label>
                    <input type="text" class="form-control" name="{{ $name->field.'_ru' }}" id="{{ $name->field.'ru' }}"  value="{{ old($name->field.'_ru') }}">
                </div>
            {{-- end ru--}}

            {{-- uz-latin--}}
                <div class="form-group">
                    <label for="{{ $name->field.'uz-latin' }}">{{ $name_lang.' UZ-LATIN '}}</label>
                    <input type="text" class="form-control" name="{{ $name->field.'_uz_latin' }}" id="{{ $name->field.'uz-latin' }}"  value="{{ old($name->field.'_uz_latin') }}">
                </div>
            {{-- end uz-latin--}}

            {{-- uz-cyrillic---}}
                <div class="form-group">
                    <label for="{{ $name->field.'uz-cyrillic' }}">{{ $name_lang.' UZ-CYRILLIC'}}</label>
                    <input type="text" class="form-control" name="{{ $name->field.'_uz_cyrillic' }}" id="{{ $name->field.'uz-cyrillic' }}"  value="{{ old($name->field.'_uz_cyrillic') }}">
                </div>
            {{-- end uz-cyrillic--}}

{{--                End name--}}

                <div class="form-group">
                    <label for="{{ $model->field }}">{{ $model->getTranslatedAttribute('display_name')}}</label>
                    <input type="text" class="form-control" name="{{ $model->field }}" id="{{ $model->field }}" @if ($model->required === 1) required @endif value="{{ old($model->field) }}">
                </div>
                @php
                    $old_brand_id = old($brand_id->field);
                @endphp
                <div class="form-group">
                    <label for="{{$brand_id->field}}">{{$brand_id->getTranslatedAttribute('display_name')}}</label>
                    <select required class="form-control select2" name="{{ $brand_id->field }}" id="{{$brand_id->field}}">
                        <option value=""> -- {{__('Select brand')}} --</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}" @if($old_brand_id == $brand->id ) selected @endif>{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="{{ $price->field }}">{{ $price->getTranslatedAttribute('display_name')}}</label>
                    <input type="number" min="0" class="form-control" name="{{ $price->field }}" id="{{ $price->field }}" @if ($price->required === 1) required @endif value="{{old($price->field)}}">
                </div>
                @php
                    $old_new = old($new->field);
                @endphp
                <div class="form-group">
                    <label for="{{ $new->field }}">{{ $new->getTranslatedAttribute('display_name')}}</label>
                    <input type="checkbox" id="{{ $new->field }}" name="{{ $new->field }}" class="toggleswitch"
                           data-on="On"
                           data-off="Off"
                           @if ($old_new ==='on')
                           checked="checked"
                           @endif
                    >
                </div>
                <div class="row" id="new-box">
                    <div class="col-md-12">
                        <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="{{$new_start->field}}">{{ $new_start->getTranslatedAttribute('display_name')}}</label>
                                            <input  id="{{$new_start->field}}" required  type="datetime" class="form-control datepicker" name="{{ $new_start->field }}"
                                                    value="{{ \Carbon\Carbon::parse(old($new_start->field))->format('m/d/Y g:i A') }}">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="{{$new_end->field}}">{{ $new_end->getTranslatedAttribute('display_name')}}</label>
                                            <input  id="{{$new_end->field}}" required  type="datetime" class="form-control datepicker" name="{{ $new_end->field }}"
                                                    value="{{ \Carbon\Carbon::parse(old($new_end->field))->format('m/d/Y g:i A') }}">

                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
                @php
                    $old_discount = old($discount->field);
                @endphp
                <div class="form-group">
                    <label for="{{ $discount->field }}">{{ $discount->getTranslatedAttribute('display_name')}}</label>
                    <input type="checkbox" id="{{ $discount->field }}" name="{{ $discount->field }}" class="toggleswitch"
                           data-on="On"
                           data-off="Off"
                           @if ($old_discount ==='on')
                           checked="checked"
                        @endif
                    >
                </div>
                <div class="row" id="discount-box">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{$discount_start->field}}">{{ $discount_start->getTranslatedAttribute('display_name')}}</label>
                                    <input  id="{{$discount_start->field}}" required  type="datetime" class="form-control datepicker" name="{{ $discount_start->field }}"
                                            value="{{ \Carbon\Carbon::parse(old($discount_start->field))->format('m/d/Y g:i A') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{$discount_end->field}}">{{ $discount_end->getTranslatedAttribute('display_name')}}</label>
                                    <input  id="{{$discount_end->field}}" required  type="datetime" class="form-control datepicker" name="{{ $discount_end->field }}"
                                            value="{{ \Carbon\Carbon::parse(old($discount_end->field))->format('m/d/Y g:i A') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="{{ $discount_price->field }}">{{ $discount_price->getTranslatedAttribute('display_name')}}</label>
                            <input type="number" min="0" class="form-control" name="{{ $discount_price->field }}" id="{{ $discount_price->field }}" value="{{ old($discount_price->field) }}" >
                        </div>
                    </div>
                </div>



                <label for="related_products">{{__('Related products')}}</label>
                <div class="form-group ">
                    <select class="form-control select2-related-products"  multiple="multiple" name="related_products[]"
                    >
                    </select>
                </div>

                @php
                    $old_category_id = old($category_id->field);
                @endphp
                <div class="form-group">
                    <label for="{{$category_id->field}}">{{$category_id->getTranslatedAttribute('display_name')}}</label>
                    <select required class="form-control select2" name="{{ $category_id->field }}" id="{{$category_id->field}}">
                        <option value=""> -- {{__('Select category')}} --</option>
                        @if ($categories !== null)
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($old_category_id == $category->id) selected @endif>{{$category->getTranslatedAttribute('name')}}</option>
                            @endforeach
                        @endif

                    </select>
                </div>



                <label for="option_types">Option type</label>
                <div class="form-group box-option">
                    <select class="form-control select2-taggable option-types" multiple="multiple" name="option_types[]">
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" id="option_types_options">

                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>{{ $image->getTranslatedAttribute('display_name')}}</label>
                    <div class="row">
                        <div id="{{$image->field}}">
                        </div>
                    </div>
                </div>
                @php
                    $old_active = old($active->field);
                @endphp

                <div class="form-group">
                    <label for="richtext{{ $description->field }}">{{ $desc_lang. ' EN '}}</label>
                    <textarea class="form-control richTextBox"  name="{{ $description->field }}" id="richtext{{ $description->field }}">{{ old($description->field) }}</textarea>
                </div>

                {{-- ru--}}
                    <div class="form-group">
                        <label for="richtext{{ $description->field.'ru' }}">{{ $desc_lang. ' RU '}}</label>
                        <textarea class="form-control richTextBox"  name="{{ $description->field.'_ru' }}" id="richtext{{ $description->field.'ru' }}">{{ old($description->field.'_ru') }}</textarea>
                    </div>
                {{-- end ru--}}

                {{-- uz-latin--}}
                    <div class="form-group">
                        <label for="richtext{{ $description->field.'uz-latin' }}">{{ $desc_lang. ' UZ-LATIN '}}</label>
                        <textarea class="form-control richTextBox"  name="{{ $description->field.'_uz_latin' }}" id="richtext{{ $description->field.'uz-latin' }}">{{ old($description->field.'_uz_latin') }}</textarea>
                    </div>
                {{-- end uz-latin--}}

                {{-- uz-cyrillic---}}
                    <div class="form-group">
                        <label for="richtext{{ $description->field.'uz-cyrillic' }}">{{ $desc_lang. ' UZ-CYRILLIC '}}</label>
                        <textarea class="form-control richTextBox"  name="{{ $description->field.'_uz_cyrillic' }}" id="richtext{{ $description->field.'uz-cyrillic' }}">{{ old($description->field.'_uz_cyrillic') }}</textarea>
                    </div>
                {{-- end uz-cyrillic--}}

                <div class="form-group">
                    <label for="{{ $active->field }}">{{ $active->getTranslatedAttribute('display_name')}}</label>
                    <input type="checkbox" id="{{ $active->field }}" name="{{ $active->field }}" class="toggleswitch"
                           data-on="On"
                           data-off="Off"
                           @if ($old_active === null)
                                checked="checked"
                           @elseif ($old_active === 'on')
                                checked="checked"
                           @elseif($old_active === 'off')

                           @endif
                    >
                </div>
        </div><!-- panel-body -->

        <div class="panel-footer">
                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
        </div>
    </form>
@endsection
@section('javascript')
    <script src="{{asset('js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function(){

            $("#{{$image->field}}").spartanMultiImagePicker({
                allowedExt:         'png|jpg|jpeg|gif',
                maxFileSize:        '2000000',
                fieldName:          '{{$image->field}}[]',
                rowHeight:          '200px',
                groupClassName:     'col-md-3 col-sm-3 col-xs-6',
                dropFileLabel :     "Drop Here",
                onAddRow:       function(index){
                    // console.log(index);
                    // console.log('add new row');
                },
                onRenderedPreview : function(index){
                    // console.log(index);
                    // console.log('preview rendered');
                },
                onRemoveRow : function(index){
                    // console.log(index);
                },
                onExtensionErr : function(index, file){
                    // console.log(index, file,  'extension err');
                    toastr.error("Please only input png or jpg type file!");
                },
                onSizeErr : function(index, file){
                    // console.log(index, file,  'file size too big');
                    toastr.error('{{__('Image size is big')}}');
                }
            });

            let selectBox = $("[class*='select2-taggable option-type']");
            selectBox.attr('disabled', 'disabled');
            let box_option = $('.box-option');
            let box_option_types_options = $('#option_types_options');
            box_option.slideUp(10);
            let category_select_box = $('#{{$category_id->field}}');
            if(category_select_box.val() !== ''){
                box_option.slideUp(100);
                let old_cat_id = category_select_box.val();
                selectBox.html('');
                selectBox.val(null);
                box_option_types_options.html('');
                let option_types = '';
                $.ajax({
                    url: '/category/'+ old_cat_id +'/option-types',
                    method  : "GET",
                    language : '{{ Auth::guard('admin')->user()->settings['locale'] }}',
                    success : function (data) {
                        $.each(data, function (key , item) {
                            let id   = item.id;
                            let text = (item['translations'].length !== 0) ? item['translations'][0].value : item.name;
                            option_types += '<option selected value="'+id+'">'+text+'</option>';
                        })
                        let all_select_boxes = '';
                        $.each(data, function (key, value) {
                            let option_type_id = value.id;
                            let txt = (value['translations'].length !== 0) ? value['translations'][0].value : value.name;
                            let optionsWithTranslations = (value['optionsWithTranslations'].length !== 0) ? value['optionsWithTranslations'] : null;
                            //console.log('optionsWithTranslations', optionsWithTranslations);
                            let select_template = '<div class="row"><div class="col-md-11"><div class="form-group"><label>'+txt+'</label><select class="form-control select2" required name="pro_options[]">';
                            let close_select_template = '</select></div></div><div class="col-md-1" style="display: flex;justify-content: center;align-items: center; height: 80px;"> <i style="cursor: pointer;" onclick="removeParent($(this))" class="fad fa-minus-square fa-2x text-danger"></i></div></div>';
                            let option_types_option = '';
                            let template = select_template;
                            if(optionsWithTranslations !== null){
                                $.each(optionsWithTranslations, function (key, value) {
                                    let lang = (value['translations'].length !== 0) ? value['translations'][0].value : value.value;
                                    option_types_option += '<option value="'+value.id+'">'+lang+'</option>';
                                })

                                template += option_types_option;
                            }else{
                                option_types_option = '<option value="">--- NO VARIANT ---</option>';
                                template += option_types_option;
                            }
                            template += close_select_template;
                            all_select_boxes += template;
                        })
                        //console.log(option_types)
                        selectBox.append(option_types);
                        box_option_types_options.append(all_select_boxes);
                        box_option.slideDown(200);
                        toastr.warning('{{__("Choose product's options") }}');
                    }
                })
            }
            box_option.find('.select2-selection__rendered').css('cursor','not-allowed');
            $('#{{$category_id->field}}').on('change', function ()  {
                box_option.slideUp(100);
                let cat_id = $(this).val();
                selectBox.html('');
                selectBox.val(null);
                box_option_types_options.html('');
                let option_types = '';
                $.ajax({
                    url: '/category/'+ cat_id +'/option-types',
                    method  : "GET",
                    language : '{{ Auth::guard('admin')->user()->settings['locale'] }}',
                    success : function (data) {
                        $.each(data, function (key , item) {
                            let id   = item.id;
                            let text = (item['translations'].length !== 0) ? item['translations'][0].value : item.name;
                            option_types += '<option selected value="'+id+'">'+text+'</option>';
                        })
                        let all_select_boxes = '';
                        $.each(data, function (key, value) {
                            let option_type_id = value.id;
                            let txt = (value['translations'].length !== 0) ? value['translations'][0].value : value.name;
                            let optionsWithTranslations = (value['optionsWithTranslations'].length !== 0) ? value['optionsWithTranslations'] : null;
                            //console.log('optionsWithTranslations', optionsWithTranslations);
                            let select_template = '<div class="row"><div class="col-md-11"><div class="form-group"><label>'+txt+'</label><select class="form-control select2" name="pro_options[]">';
                            let close_select_template = '</select></div></div><div class="col-md-1" style="display: flex;justify-content: center;align-items: center; height: 80px;"> <i style="cursor: pointer;" onclick="removeParent($(this))" class="fad fa-minus-square fa-2x text-danger"></i></div></div>';
                            let option_types_option = '';
                            let template = select_template;
                            if(optionsWithTranslations !== null){
                                $.each(optionsWithTranslations, function (key, value) {
                                    let lang = (value['translations'].length !== 0) ? value['translations'][0].value : value.value;
                                    option_types_option += '<option value="'+value.id+'">'+lang+'</option>';
                                })
                                template += option_types_option;
                            }else{
                                option_types_option = '<option value="-1">--- NO ---</option>';
                                template += option_types_option;
                            }
                            template += close_select_template;
                            all_select_boxes += template;
                        })
                        //console.log(option_types)
                        selectBox.append(option_types);
                        box_option_types_options.append(all_select_boxes);
                        box_option.slideDown(200);
                        toastr.warning('{{__("Choose product's options") }}');
                    }
                })
            })

            selectBox.trigger('change', function (e) {
                toastr.info(e.params.data.value);
            })
            selectBox.on('select2:unselecting', function (e) {
                let unselect =  selectBox.val();
                toastr.success(e.params.args.data);
                // toastr.success(e.params.data.value);
            })

        });
        function removeParent(elem) {
            let removing_elem = elem.parent().parent();
            removing_elem.remove();
        }
        $(".select2-related-products").select2({
            width: '100%',
            tags: true,
            allowClear: true,
            createTag: function(params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            },
            ajax: {
                method: 'GET',
                url: '/related-products',
                dataType: 'json',
                language : '{{ Auth::guard('admin')->user()->settings['locale'] }}',
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page
                    };
                },

                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    if(data.results.length > 0){
                        return {
                            results: data.results,
                            pagination: {
                                 more: (params.page * 10) < data.total_count
                            }
                        };
                    }else{
                        return {
                            results: []
                        }
                    }

                },
                cache: true
            },
            placeholder: '{{__('Search product')}}',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
        });


        function formatRepo (repo) {
            if (repo.loading)
            {
                console.log(repo);
                return repo.text;

            }else {
                var $container = $(
                    "<div class='row' style='margin: 0'>" +
                    "<div class='col-1' style='display: inline-block; margin-right: 10px '>" +
                    "<div  class='select2-result-repository__avatar'><img style='width: 80px;' src='" + repo.image + "' /></div>" +
                    "</div>" +
                    "<div class='col-11' style='display: inline-block; margin-left: 10px'>" +
                    "<h4 class='select2-result-repository__name'></h4>" +
                    "<h5 class='select2-result-repository__model'></h5>" +
                    "</div></div>"
                );

                $container.find(".select2-result-repository__name").text(repo.name);
                $container.find(".select2-result-repository__model").text(repo.model);
                console.log(repo);
                return $container;
            }



        }

        function formatRepoSelection (repo) {
            return repo.name || repo.text;
        }
// new box start
        let newBox = $('#new-box');
        let newButton = $('#{{$new->field}}');
        if(!newButton.prop('checked')){
            newBox.slideUp();
        }else{
            newBox.slideDown();
        }
        newButton.change(function() {
            if (!$(this).parent().hasClass('off')) {
                newBox.slideDown(500);
            }else{
                newBox.slideUp(500);
            }
        });
// new box end

// discount box start
        let discountBox = $('#discount-box');
        let discountButton = $('#{{$discount->field}}');
        if(!discountButton.prop('checked')){
            discountBox.slideUp();
        }else{
            discountBox.slideDown();
        }
        discountButton.change(function() {
            if (!$(this).parent().hasClass('off')) {
                discountBox.slideDown(500);
            }else{
                discountBox.slideUp(500);
            }
        });


// discount box end
    </script>
    <script>
        $(document).ready(function() {
            $('.toggleswitch').bootstrapToggle();

            var additionalConfigEn = {
                selector: 'textarea.richTextBox[name="{{ $description->field }}"]',
            }
            $.extend(additionalConfigEn, {!! json_encode($options->tinymceOptions ?? '{}') !!})
            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfigEn));

            var additionalConfigRu = {
                selector: 'textarea.richTextBox[name="{{ $description->field.'_ru' }}"]',
            }
            $.extend(additionalConfigRu, {!! json_encode($options->tinymceOptions ?? '{}') !!})
            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfigRu));

            var additionalConfigUzLatin = {
                selector: 'textarea.richTextBox[name="{{ $description->field.'_uz_latin' }}"]',
            }
            $.extend(additionalConfigUzLatin, {!! json_encode($options->tinymceOptions ?? '{}') !!})
            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfigUzLatin));

            var additionalConfigUzCyrillic = {
                selector: 'textarea.richTextBox[name="{{ $description->field.'_uz_cyrillic' }}"]',
            }
            $.extend(additionalConfigUzCyrillic, {!! json_encode($options->tinymceOptions ?? '{}') !!})
            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfigUzCyrillic));

        });
    </script>
@stop
