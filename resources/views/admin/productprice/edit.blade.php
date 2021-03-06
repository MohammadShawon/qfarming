<?php
    use Carbon\Carbon;
?>
@extends('template.app')

@section('title', 'Update - Product Price')

@push('css')
   <!--select2-->
   <link href="{{ asset('admin/assets/plugins/select2/css/select2.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

   <!-- date time -->
   <link href="{{ asset('admin/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }} " rel="stylesheet" media="screen">
@endpush

@section('content')
    <div class="page-bar">
        <div class="page-title-breadcrumb">
            
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12 col-sm-12">
            <div class="card card-box">
                <div class="card-head text-white " style="background-color:#3FCC7E;">
                    <header>Update Product - Price</header>
                </div>
                <div class="card-body" id="bar-parent">
                    <form method="post" action="{{ route('admin.product-price.update', $productPrice->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-sm-6">

                                {{-- Product Name --}}
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <select name="product_id" class="form-control  select2 " >
                                        @foreach ($products as $product)
                                            <option 
                                            {{ $productPrice->product_id == $product->id ? 'selected':''}}
                                            value="{{ $product->id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Batch No --}}
                                <div class="form-group">
                                    <label for="batch">Batch No </label>
                                    
                                    <input type="text" class="form-control" id="batch" value="{{ $productPrice->batch_no }}"  name="batch" >
                                </div>

                                {{-- Quantity --}}
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" name="quantity" class="form-control" id="quantity" value="{{ $productPrice->quantity }}">
                                </div>

                                {{-- Cost --}}
                                <div class="form-group">
                                    <label for="cost">Cost Price</label>
                                    <input type="text" name="cost" class="form-control" id="cost" value="{{ $productPrice->cost_price }}">
                                </div>
                            </div>

                        
                            <div class="col-md-6 col-sm-6">
                                
                                {{-- Sell --}}
                                <div class="form-group">
                                    <label for="sell">Sell Price</label>
                                    <input type="text" name="sell" class="form-control" id="sell" placeholder="Enter Selling price" value="{{ $productPrice->selling_price }}">
                                </div>
                                
                                {{-- M.F.G  date --}}
                                <div class="form-group">
                                    <label class="">M.F.G Date</label>
                                    <div class="input-group date form_datetime" data-date="{{ Carbon::now() }}" data-date-format="dd MM yyyy HH:ii p" data-link-field="dtp_input1">
                                        <input class="form-control" size="16" type="text" name="mfg_date" value="{{ old('mfg_date') }}">
                                        <span class="input-group-addon ml-2">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>

                                {{-- E.X.P  date --}}
                                <div class="form-group">
                                    <label class="">EXP Date</label>
                                    <div class="input-group date form_datetime" data-date="{{ Carbon::now() }}" data-date-format="dd MM yyyy  HH:ii p" data-link-field="dtp_input1">
                                        <input class="form-control" size="16" type="text" name="exp_date" value="{{ old('exp_date') }}">
                                        <span class="input-group-addon ml-2">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                        </div>

                        

                        {{-- <div class="form-group">
                            <label for="simpleFormEmail">Status</label>
                            <input type="text" name="status" class="form-control" id="simpleFormEmail" placeholder="Enter farmer status" value="{{ old('status') }}">
                        </div> --}}
                        
                        <a class="btn deepPink-bgcolor m-t-15 waves-effect" href="{{ route('admin.product-price.index') }}">BACK</a>
                        <button type="submit" class="btn btn-success m-t-15 waves-effect">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!--select2-->
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.js') }}" ></script>
    <script src="{{ asset('admin/assets/js/pages/select2/select2-init.js') }}" ></script>

    <!-- data time -->
    <script src="{{ asset('admin/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"  charset="UTF-8"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker-init.js') }}"  charset="UTF-8"></script>
@endpush
