@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الاقسام الرئيسية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> الاقسام الرئيسية
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع الاقسام الرئيسية </h4>
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


                                <ul class="nav nav-tabs nav-linetriangle no-hover-bg">
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab41" data-toggle="tab" aria-controls="tab41" href="#tab41" aria-expanded="true">البيانات الأساسية</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab42" data-toggle="tab" aria-controls="tab42" href="#tab42" aria-expanded="false">السعر</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="base-tab43" data-toggle="tab" aria-controls="tab43" href="#tab43" aria-expanded="false">صور المنتج</a>
                                    </li>
                                  </ul>
                                  <div class="tab-content">
                                  <div role="tabpanel" class="tab-pane" id="tab41" aria-expanded="true" aria-labelledby="base-tab41">
                                      aaaaaaaaaa
                                  </div>
                                  <div class="tab-pane" id="tab42" aria-labelledby="base-tab42">
                                      Price
                                  </div>
                                  <div class="tab-pane active" id="tab43" aria-labelledby="base-tab43">
                                      Image
                                  </div>
                                </div>










                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @stop

