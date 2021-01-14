@extends('layouts.admin')
@push('script')


    @section('content')

        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}"> الاقسام </a>
                                    </li>
                                    <li class="breadcrumb-item active">إضافة قسم جديد
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
                                        <h4 class="card-title" id="basic-layout-form"> إضافة قسم جديد </h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
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
                                            <form class="form" action="{{ route('admin.categories.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf


                                                <div class="form-group">
                                                    <label> صوره القسم </label>
                                                    <label id="projectinput7" class="file center-block">
                                                        <input type="file" id="file" name="photo">
                                                        <span class="file-custom"></span>
                                                    </label>
                                                    @error('photo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-body">


                                                    <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>
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

                                                    <div class="row hidden" id="cats_list">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="parent_id"> اختر القسم الرئيسي
                                                                </label>
                                                                <select id="parent_id"
                                                                name="parent_id" style="width:auto;" class=" form-control">
                                                                    <optgroup label="من فضلك أختر القسم ">
                                                                        @if ($categories && $categories->count() > 0)
                                                                                    @php
                                                                                    if (App::getLocale() == "ar")
                                                                                        subCatRecursion($categories, 0,'←');
                                                                                    else
                                                                                        subCatRecursion($categories, 0,'→');

                                                                                    @endphp
                                                                        @endif
                                                                    </optgroup>
                                                                </select>
                                                                @error('parent_id')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mt-1">
                                                                <input type="checkbox" value="1" name="is_active"
                                                                    id="switcheryColor4" class="switchery"
                                                                    data-color="success" @if(old('is_active') == '1')checked @endif />
                                                                <label for="switcheryColor4" class="card-title ml-1">الحالة
                                                                </label>

                                                                @error("is_active")
                                                                <span class="text-danger">{{ $message }} </span>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="col-md-3">
                                                            <div class="form-group mt-1">
                                                                <input id="main" type="radio" name="type" value="1" checked
                                                                @if(old('type') == '1')checked @endif
                                                                class="switchery" data-color="success" />

                                                                <label for="main" class="card-title ml-1">
                                                                    قسم رئيسي
                                                                </label>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group mt-1">
                                                                <input id="sub" type="radio" name="type" value="2"
                                                                @if(old('type') == '2')checked @endif
                                                                class="switchery"
                                                                    data-color="success" />

                                                                <label for="sub" class="card-title ml-1">
                                                                    قسم فرعي
                                                                </label>

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
                                                        <i class="la la-check-square-o"></i> إضافة
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

    @endsection
    @section('script')

        <script>
            $(document).ready(function() {

                $('input:radio[name="type"]').each(function() {
                    if (this.checked && this.value == '2') { // 1 if main cat - 2 if sub cat
                        $('#cats_list').removeClass('hidden');
                    } else {
                        $('#cats_list').addClass('hidden');
                    }
                });
            });

            $('input:radio[name="type"]').change(
                function() {
                    if (this.checked && this.value == '2') { // 1 if main cat - 2 if sub cat
                        $('#cats_list').removeClass('hidden');
                    } else {
                        $('#cats_list').addClass('hidden');
                    }
                });

        </script>
    @stop
