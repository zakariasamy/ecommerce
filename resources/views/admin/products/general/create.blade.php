@extends('layouts.admin')
@section('style')



@endsection
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="">
                                        المنتجات </a>
                                </li>
                                <li class="breadcrumb-item active"> أضافه منتج
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> أضافة منتج جديد </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.products.general.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf


                                            <ul class="nav nav-tabs nav-linetriangle no-hover-bg">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="base-tab41" data-toggle="tab" aria-controls="tab41" href="#tab41" aria-expanded="true">البيانات الأساسية</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="base-tab42" data-toggle="tab" aria-controls="tab42" href="#tab42" aria-expanded="false">السعر</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="base-tab43" data-toggle="tab" aria-controls="tab43" href="#tab43" aria-expanded="false">التخزين</a>
                                                </li>
                                              </ul>
                                            <div class="tab-content">

                                            <div role="tabpanel" class="tab-pane active form-body pt-3" id="tab41" aria-labelledby="base-tab41">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name"> اسم  المنتج
                                                            </label>
                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('name')}}"
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description"> وصف المنتج
                                                            </label>
                                                            <textarea

                                                            id="description" name="description" id="description"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                            >{{old('description')}}</textarea>

                                                            @error("description")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="short_description"> الوصف المختصر
                                                            </label>
                                                            <textarea id="short_description" name="short_description" id="short_description"
                                                                       class="form-control"
                                                                       placeholder=""
                                                            >{{old('short_description')}}</textarea>

                                                            @error("short_description")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row" >
                                                    <div class="col-md-4">
                                                        <div class="form-group">

                                                            <label for="categories[]"> اختر القسم
                                                            </label>
                                                            <select id="categories[]" name="categories[]" class="select2 form-control" multiple>
                                                                <optgroup label="من فضلك أختر القسم ">
                                                                    @if($categories && $categories -> count() > 0)
                                                                        @foreach($categories as $category)
                                                                            <option
                                                                            @if(old('categories'))
                                                                                @foreach((old('categories')) as $oldCat)

                                                                @if($oldCat==$category->id) selected @endif
                                                                @endforeach
                                                                 @endif
                                                                value="{{$category -> id }}">{{$category -> name}}{{old('categories[]')}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>

                                                            @error('categories')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="tags"> اختر ألعلامات الدلالية
                                                            </label>
                                                            <select id="tags" name="tags" class="select2 form-control" multiple>
                                                                <optgroup label=" اختر ألعلامات الدلالية ">
                                                                    @if($tags && $tags -> count() > 0)
                                                                        @foreach($tags as $tag)
                                                                            <option
                                                                            @if(old('tags')==$tag->id) selected @endif
                                                                                value="{{$tag -> id }}">{{$tag -> name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('tags')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="brand_id"> اختر ألماركة
                                                            </label>
                                                            <select id="brand_id" name="brand_id" class="select2 form-control">
                                                                    <option disabled selected >  غير محدد  </option>
                                                                    @if($brands && $brands -> count() > 0)
                                                                        @foreach($brands as $brand)
                                                                            <option
                                                                            @if(old('brand_id')==$brand->id) selected @endif
                                                                                value="{{$brand -> id }}">{{$brand -> name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                            </select>
                                                            @error('brand_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="is_active"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   checked/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة </label>

                                                            @error("is_active")
                                                            <span class="text-danger">{{$message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="tab-pane form-body pt-3" id="tab42" aria-labelledby="base-tab42">
                                                <div class="card">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="price"> السعر
                                                            </label>
                                                            <input type="number" id="price"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('price')}}"
                                                                   name="price">
                                                            @error("price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="special_price"> سعر خاص
                                                                <span style="color:green">(اختياري)</span>
                                                            </label>
                                                            <input type="number" id="special_price"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   min="0"
                                                                   value="{{old('special_price')}}"
                                                                   name="special_price">
                                                            @error("special_price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="special_price_type"> نوع السعر الخاص
                                                                <span style="color:green">(حال إدخال سعر خاص)</span>
                                                            </label>
                                                            <select disabled id="special_price_type" name="special_price_type" class=" form-control">
                                                                <option
                                                                @if(old('special_price_type')=="fixed") selected @endif

                                                                value="fixed">fixed</option>
                                                                <option
                                                                @if(old('special_price_type')=="percent") selected @endif
                                                                value="percent">percent</option>
                                                            </select>
                                                            @error('special_price_type')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="special_price_start"> تاريخ بداية السعر الخاص
                                                                <span style="color:green">(حال إدخال سعر خاص)</span>
                                                            </label>
                                                            <input disabled type="date" id="special_price_start"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('special_price_start')}}"
                                                                   name="special_price_start">
                                                            @error('special_price_start')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="special_price_end"> تاريخ نهاية السعر الخاص
                                                                <span style="color:green">(حال إدخال سعر خاص)</span>
                                                            </label>
                                                            <input disabled type="date" id="special_price_end"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('special_price_end')}}"
                                                                   name="special_price_end">
                                                            @error('special_price_end')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                                </div>
                                            <div class="tab-pane form-body pt-3" id="tab43" aria-labelledby="base-tab43">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="sku"> كود  المنتج
                                                            </label>
                                                            <input type="text" id="sku"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('sku')}}"
                                                                   name="sku">
                                                            @error("sku")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="in_stock">حالة المنتج
                                                            </label>
                                                            <select id="in_stock" name="in_stock" class="form-control" >
                                                                <optgroup label="من فضلك أختر  ">
                                                                    <option
                                                                    @if(old('in_stock')=="1") selected @endif
                                                                    value="1">متاح</option>
                                                                    <option
                                                                    @if(old('in_stock')=="0") selected @endif
                                                                    value="0">غير متاح </option>
                                                                </optgroup>
                                                            </select>
                                                            @error('in_stock')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="manage_stock">تتبع المستودع
                                                            </label>
                                                            <select id="manage_stock" name="manage_stock" class="form-control">
                                                                <optgroup label="من فضلك أختر النوع ">
                                                                    <option @if(old('manage_stock')=='0') selected @endif value="0">عدم اتاحه التتبع</option>
                                                                    <option @if(old('manage_stock')=='1') selected @endif value="1">اتاحة التتبع</option>
                                                                </optgroup>
                                                            </select>
                                                            @error('manage_stock')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                  <!-- QTY  -->

                                                    <div class="col-md-6" style="display:none"  id="qtyDiv">
                                                        <div class="form-group">
                                                            <label for="qty">الكمية
                                                            </label>
                                                            <input type="text" id="qty"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('qty')}}"
                                                                   name="qty">
                                                            @error("qty")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            </div>


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> اضافة
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>

    </div>
@stop


@section('script')

    <script>
        // Price
        $('#special_price').on('keyup change',function(e){
            console.log('yes');

            if($(this).val() == ''){
                $('#special_price_type').prop("disabled", 'disabled');
                $('#special_price_start').prop("disabled", 'disabled');
                $('#special_price_end').prop("disabled", 'disabled');
            }
            else{
                $('#special_price_type').prop("disabled", false);
                $('#special_price_start').prop("disabled", false);
                $('#special_price_end').prop("disabled", false);
            }
            });

        $( document ).ready(function() {
            if($('#special_price').val() == ''){
                    $('#special_price_type').prop("disabled", 'disabled');
                    $('#special_price_start').prop("disabled", 'disabled');
                    $('#special_price_end').prop("disabled", 'disabled');
                }
                else{
                    $('#special_price_type').prop("disabled", false);
                    $('#special_price_start').prop("disabled", false);
                    $('#special_price_end').prop("disabled", false);
                }

                if($("#manage_stock").val() == '1'){
                    $("#qtyDiv").fadeIn();
                    $("#qty").attr('disabled',false);
                }
                else{
                    $("#qtyDiv").fadeOut();
                    $("#qty").attr('disabled',true); // TO ensure that if user entered value then Made manae stock (0)
                    // Then the value will Not be returned
                }
        });

        // Inventory
        $("#manage_stock").change(function (e) {
            if($(this).val() == '1'){
                $("#qtyDiv").fadeIn();
                $("#qty").attr('disabled',false);

            }
            else{
                $("#qtyDiv").fadeOut();
                $("#qty").attr('disabled',true); // TO ensure that if user entered value then Made manae stock (0)
                // Then the value will Not be returned
            }
        });

    </script>
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'description',{
    language: 'ar'
    }
    );
</script>
    @stop

