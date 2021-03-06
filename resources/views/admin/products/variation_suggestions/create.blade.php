@extends('layouts.admin')
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
                                <li class="breadcrumb-item"><a href="{{route('admin.products.var.suggest')}}">  خصائص المنتجات </a>
                                </li>
                                <li class="breadcrumb-item active">  أضافه خاصية جديدة
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
                                    <h4 class="card-title" id="basic-layout-form"> أضافه خاصية تجارية </h4>
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
                                              action="{{route('admin.products.var.suggest.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf


                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> بيانات الخاصية </h4>
                                                <div class="row">
                                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="name_{{ $localeCode }}">{{ __('admin/form.name_' . $localeCode) }}
                                                            </label>
                                                            <input type="text" value="{{ old('name.' . $localeCode) }}"
                                                                id="name_{{ $localeCode }}" class="form-control"
                                                                name="name[{{ $localeCode }}] ">
                                                            @error("name." . $localeCode)
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endforeach


                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                                            <label for="categories[]"> اختر القسم
                                                            </label>
                                                            <select id="categories[]" name="categories[]" class="select2 form-control" multiple>
                                                                <optgroup label="من فضلك أختر القسم ">
                                                                    <option value="-1">كل الأقسام</option>
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
