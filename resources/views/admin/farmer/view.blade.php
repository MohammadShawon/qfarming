<?php
use Carbon\Carbon;
?>
@extends('template.app')
@section('title', 'Farmer Record Dashboard')
@push('css')
<!-- data tables -->
<link href="{{ asset('admin/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css')}} " rel="stylesheet" type="text/css"/>
@endpush
@section('content')
<div class="row justify-content-center">
    <div class="col-md-3 justify-content-center">
        <div class="card">
            <div class="card-head">
                <header>
                    Profile Picture
                </header>
            </div>
            <div class="card-body no-padding height-9">
                
                <div class="profile-userpic">
                    <img src="{{ asset('storage/farmer/')."/".$farmer->image }}" class="img-responsive" alt="">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-head">
                <header>
                    Quick Links
                </header>
            </div>
            <div class="card-body">

                <div class="">
                    <a href="{{ url('/farmer/'.$farmer->id.'/batch/create') }}" class="btn btn-success btn-lg btn-block">Create Batch</a>
                    <a class="btn btn-primary btn-lg btn-block">Farmer Invoice</a>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6 justify-content-center">
        <div class="row justify-content-center">
            <h1 class="font-weight-bolder"><b>Forazi Agro Ltd.</b></h1>
        </div>
        <div class="card">
            <div class="card-body no-padding height-9">
                
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> Farmer Profile </div>
                </div>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>ID</b> <a class="pull-right">{{ $farmer->id}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Name</b> <a class="pull-right">{{ $farmer->name }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Address</b> <a class="pull-right">{{ $farmer->address}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Total Cost</b> <a class="pull-right">25,000</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-3 justify-content-center">
        <div class="card">
            <div class="card-body no-padding height-9">
                
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        Round - {{ $farmer->farmerbatches->count() }}
                    </div>
                </div>
                <ul class="list-group list-group-unbordered">
                    @php
                        $latestBatch = DB::table('farmer_batches')->first();
                        if (!empty($latestBatch))
                        {
                            $startDate = \Carbon\Carbon::parse($latestBatch->created_at);
                            $endDate = \Carbon\Carbon::now();
                        }
                    @endphp
                    <li class="list-group-item">
                        Opening Date <a class="pull-right">
                            <b>
                                {{ $latestBatch !== null ? date('M d, y', strtotime($latestBatch->created_at)) : 'No Batch' }}
                                </b>
                        </a>
                    </li>
                    @if(!empty($latestBatch))
                        <li class="list-group-item">
                            Running Day <a class="pull-right p-r-20 mdl-color-text--red-900">
                                <b>
                                    {{ ($startDate->diffInDays($endDate) !== 0 ?$startDate->diffInDays($endDate) : 1) }}
                                </b>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
                <a class="btn blue btn-outline m-b-10 btn-lg btn-block">Daily Reports</a>
                <a class="btn red btn-outline btn-lg btn-block">Report Summary</a>
    </div>

</div>

<div class="row">

    <div class="col-sm-2">
        <div class="panel">
            <header class="panel-heading panel-heading-blue text-center">
                <strong> Age</strong>
            </header>
            <div class="panel-body text-center">
                <b>18 Days</b>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="panel">
            <header class="panel-heading panel-heading-blue text-center">
                <strong>Total Died</strong>
            </header>
            <div class="panel-body text-center">
                <b>18</b>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="panel">
            <header class="panel-heading panel-heading-blue text-center">
                <b>Total Feed</b>
            </header>
            <div class="panel-body text-center">
                <b>120 kg</b>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="panel">
            <header class="panel-heading panel-heading-blue text-center">
                <strong>Total Feed</strong>
            </header>
            <div class="panel-body text-center">
                <b>2.2 Sack</b>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="panel">
            <header  class="panel-heading panel-heading-blue text-center">
                <strong>Feed Left</strong>
            </header>
            <div class="panel-body text-center">
                <b>4.3 Sack</b>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="panel">
            <header class="panel-heading panel-heading-blue text-center">
                <strong>Weigh Per Pics</strong>
            </header>
            <div class="panel-body text-center">
                <b>400 gm</b> (Now)
            </div>
        </div>
    </div>
</div>
    <!--
    ---Batch & Stock Report Accordations
    -->
<div class="row">
    <div class="col-12">
        <div class="panel tab-border card-box">
            <header class="panel-heading panel-heading-gray custom-tab ">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a href="#stock" data-toggle="tab" class="active">Medicine & Feed</a>
                    </li>
                    <li class="nav-item"><a href="#batch" data-toggle="tab">Batch Details</a>
                    </li>

                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="stock">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body " style="">
                                    <div class="table-scrollable">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Feed and Medicin</th>
                                                <th>Quantity</th>
                                                <th>Cost</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>22 July, 19</td>
                                                <td>Name of Feed or Medicine</td>
                                                <td>2</td>
                                                <td>450</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>23 July, 19</td>
                                                <td>Name of Feed or Medicine</td>
                                                <td>12</td>
                                                <td>8000</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>24 July, 19</td>
                                                <td>Name of Feed or Medicine</td>
                                                <td>4</td>
                                                <td>750</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="batch">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head text-center">
                                        <header style="padding: 25px 0;">All BATCH RECORDS</header>
                                    </div>
                                    <div class="card-body" id="line-parent">
                                        <div class="panel-group accordion" id="accordion3">
                                            @foreach ($farmer->farmerbatches as $farmerBatch)
                                                <div class="panel panel-default" >
                                                    <div class="panel-heading panel-heading-gray">
                                                        <h4 class="panel-title">
                                                            <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#{{$farmerBatch->batch_number}}">

                                                                {{-- Batch Name, Batch Number , Batch Status --}}

                                                                Batch Name :  <span class="btn btn-{{($farmerBatch->status=='active')?'success':'danger' }}">{{ $farmerBatch->batch_name }}</span> <span aria-hidden="true" class="icon-arrow-right "></span>
                                                                Batch Number : <span class="btn btn-{{($farmerBatch->status=='active')?'success':'danger' }}">{{ $farmerBatch->batch_number }}</span> <span aria-hidden="true" class="icon-arrow-right "></span>

                                                                Status : <span class="btn btn-{{($farmerBatch->status=='active')?'success':'danger' }}">{{ ($farmerBatch->status == 'active') ? 'Running' : 'Closed' }}</span>



                                                            </a>
                                                            <span class="pull-right">
                                                <a class="text-primary" href="{{ url('/farmer/'.$farmer->id.'/batch/'.$farmerBatch->id.'/edit') }}">Edit</a> |
                                                <a class="text-danger" onclick="deleteFarmerBatch({{$farmerBatch->id}})" href="#">Delete</a>

                                                <form id="delete-form-{{$farmerBatch->id}}" action="{{ url('/farmer/'.$farmer->id.'/batch/'.$farmerBatch->id) }}" method="post" style="display:none;">
                                                    @csrf
                                                    @method("DELETE")
                                                </form>
                                            </span>

                                                        </h4>
                                                    </div>
                                                    <div id="{{$farmerBatch->batch_number}}" class="panel-collapse in collapse">
                                                        <br>
                                                        <div class="row justify-content-center">
                                                            <div class="col-sm-6">

                                                                {{-- Add Todays Record Button --}}
                                                                <a data-toggle="modal" data-target="#farmerRecordForm" class="btn btn-info btn-lg m-b-10">Add Todays Record</a>

                                                                {{--View FUll Record Button --}}
                                                                <a href="" class="btn btn-primary btn-lg m-b-10">View Full Record</a>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="text-center">
                                                                <tr>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Age</b></p>
                                                                    </th>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Died</b></p>
                                                                    </th>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Feed Eaten - kg</b></p>
                                                                    </th>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Feed Eaten - Sack</b></p>
                                                                    </th>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Feed left</b></p>
                                                                    </th>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Wieght</b></p>
                                                                    </th>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Sickness</b></p>
                                                                    </th>
                                                                    <th>
                                                                        <p style="font-size:17px; color:#A52A2A;"><b>Comments</b></p>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr class="text-center">
                                                                    <td>1</td>
                                                                    <td>5</td>
                                                                    <td>20 kg</td>
                                                                    <td>0.01 Sack</td>
                                                                    <td>20.01 Sack</td>
                                                                    <td>100gm</td>
                                                                    <td style="max-width: 150px;">Well</td>
                                                                    <td style="max-width: 250px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad iure nesciunt eaque reprehenderit a.</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
    <!--
    --- Batch & Stock Report Ends
    -->
    <!--
    --  Modal Records Form
    -->
    @include('admin.modals.farmers.daily-record')

@csrf
{{--
<div class="row justify-content-center">
<div class="col-sm-6">
<br><br>
<a href="{{ route('admin.farmer-records.create') }}" class="btn btn-danger btn-lg m-b-10">
    Add Todays Record
</a>
<a href="{{ route('admin.farmer-records.index') }}" class="btn btn-success btn-lg m-b-10">
    View Full Record
</a>
</div>
</div> --}}
@endsection
@push('js')
<!-- data tables -->
<script src="{{ asset('admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js') }}" ></script>
<script src="{{ asset('admin/assets/js/pages/table/table_data.js') }}" ></script>
<!-- sweet aleart -->
<script src="{{ asset('admin/assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    function deleteFarmerBatch(id) {
    const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false,
    })
    swalWithBootstrapButtons.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
    }).then((result) => {
    if (result.value) {
    event.preventDefault();
    document.getElementById("delete-form-"+id).submit();
    } else if (
    // Read more about handling dismissals
    result.dismiss === Swal.DismissReason.cancel
    ) {
    swalWithBootstrapButtons.fire(
    'Cancelled',
    'Your Farmer Batch is safe :)',
    'error'
    )
    }
    })
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
    $(".add-row").click(function(){
    var age = $("#age").val();
    var died = $("#died").val();
    var feed_kg = $("#feed_kg").val();
    var feed_sack = $("#feed_sack").val();
    var feed_left = $("#feed_left").val();
    var weight = $("#weight").val();
    var sickness = $("#sickness").val();
    var comment = $("#comment").val();
    var markup = "<tr class='text-center'><td><input type='checkbox' name='record'></td><td>" + age+ "</td><td>" + died+ "</td><td>" + feed_kg+ "</td><td>" + feed_sack+ "</td><td>" + feed_left + "</td><td>" + weight+ "</td><td style='max-width: 150px;'>" + sickness+ "</td><td style='max-width: 250px;'>" + comment+ "</td></tr>";
    $("table tbody").append(markup);
    });
    // Find and remove selected table rows
    $(".delete-row").click(function(){
    $("table tbody").find('input[name="record"]').each(function(){
    if($(this).is(":checked")){
    $(this).parents("tr").remove();
    }
    });
    });
    });
</script>
{{-- Record Form Js --}}
<script src="{{ asset('js/daily-record-form.js') }}"></script>
@endpush
