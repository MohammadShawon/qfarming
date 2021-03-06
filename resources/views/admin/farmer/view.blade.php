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
    <div id="app">
        <div class="row">
            <div class="col-12">
                <h2 class="font-weight-bolder font-weight-bolder text-center"><b>
                        {{ env('COMPANY_NAME','QBYTESOFT') }} <span class="label label-rouded label-danger">{{ auth()->user()->branch->name }}</span></b>
                </h2>
            </div>
        </div>
        {{--Profile Quick Links--}}
        <div class="row justify-content-center">
            <div class="col-md-3 justify-content-center">
                <div class="card">
                    <div class="card-head">
                        <header>
                            Profile Picture
                        </header>
                    </div>
                    <div class="card-body no-padding height-9">

                        <div class="patient-profile">
                            <img src="{{ asset('storage/farmer/').'/'.$farmer->image }}" class="img-responsive" alt="">
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
                            <a href="{{ url('/farmer/'.$farmer->id.'/invoice') }}" class="btn btn-primary btn-lg btn-block">Farmer Invoice</a>
                        </div>
                    </div>
                </div>

            </div>
            {{--Farmer Profile--}}
            <div class="col-md-6 justify-content-center">

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
                                <b>Phone</b> <a class="pull-right">{{ $farmer->phone1??$farmer->phone2 }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Address</b> <a class="pull-right">{{ $farmer->address}}</a>
                            </li>

                            <li class="list-group-item">
                                <b>Total Cost</b>
                                <a class="pull-right">
                                    {{ \App\Helpers\Farmers::totalCost($farmer->id) }}
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Total Collection</b>
                                <a class="pull-right">
                                    {{ \App\Helpers\Farmers::totalCollection($farmer->id) }}
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Current Balance</b>
                                <a class="pull-right">
                                    {{ \App\Helpers\Farmers::currentBalance($farmer->id) }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{--Chicks Summary--}}
            <div class="col-md-3 justify-content-center">
                <div class="card">
                    <div class="card-body no-padding height-9">

                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                Round - {{ $farmer->farmerbatches->where('status','active')->count() }}
                            </div>
                        </div>
                        <ul class="list-group list-group-unbordered">
                            @php
                                $latestBatch = DB::table('farmer_batches')->where('farmer_id',$farmer->id)->where('status','active')->orderBy('id','desc')->first();
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

                            <li class="list-group-item">
                                Running Day
                                @if(!empty($latestBatch))
                                    <a class="pull-right p-r-20 mdl-color-text--red-900">

                                        <b>
                                            {{ ($startDate->diffInDays($endDate) !== 0 ?$startDate->diffInDays($endDate) + 1 : 1) }}
                                        </b>
                                    </a>
                                @endif
                            </li>
                            <li class="list-group-item">
                                Current Chicks
                                @if(!empty($latestBatch))
                                    <a class="pull-right p-r-20 mdl-color-text--red-900">

                                        <b>
                                            {{ $latestBatch->chicks_quantity }}
                                        </b>
                                    </a>
                                @endif
                            </li>

                            <li class="list-group-item">

                                Price
                                @if(!empty($latestBatch))
                                    <a class="pull-right p-r-20 mdl-color-text--red-900">

                                        <b>
                                            {{ \App\Helpers\Farmers::currentChicksPrice($farmer->id) }}
                                        </b>
                                    </a>
                                @endif
                            </li>


                        </ul>
                    </div>
                </div>
                {{--Quick Link Right--}}
                <div class="card">
                    <div class="card-head">
                        <header>
                            Quick Links
                        </header>
                    </div>
                    <div class="card-body">

                        <div class="">
                            <a class="btn blue btn-outline m-b-10 btn-lg btn-block" id="daily-reports-button">Daily Reports</a>
                            <a class="btn red btn-outline btn-lg btn-block">Report Summary</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row" id="daily-reports">

            <div class="col-sm-2">
                <div class="panel">
                    <header class="panel-heading panel-heading-blue text-center">
                        <strong> Age</strong>
                    </header>
                    <div class="panel-body text-center">
                        @if(!empty($latestBatch))

                            <b>
                                {{ ($startDate->diffInDays($endDate) !== 0 ?$startDate->diffInDays($endDate) + 1 : 1) }}
                            </b>

                        @else
                            <b>
                                0
                            </b>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="panel">
                    <header class="panel-heading panel-heading-blue text-center">
                        <strong>Total Died</strong>
                    </header>
                    <div class="panel-body text-center">
                        <b>{{ !empty($latestBatch) ? App\Helpers\Farmers::totalDied($farmer->id) : 0}}</b>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="panel">
                    <header class="panel-heading panel-heading-blue text-center">
                        <b>Total Feed</b>
                    </header>
                    <div class="panel-body text-center">
                        <b>{{ !empty($latestBatch) ? App\Helpers\Farmers::totalFeed($farmer->id) : 0 }} Kg</b>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="panel">
                    <header class="panel-heading panel-heading-blue text-center">
                        <strong>Total Feed</strong>
                    </header>
                    <div class="panel-body text-center">
                        <b>{{ !empty($latestBatch) ? App\Helpers\Farmers::totalFeed($farmer->id) / 50 : 0 }} Sack</b>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="panel">
                    <header  class="panel-heading panel-heading-blue text-center">
                        <strong>Feed Left</strong>
                    </header>
                    <div class="panel-body text-center">
                        <b>{{ !empty($latestBatch) ? App\Helpers\Farmers::totalFeedLeft($farmer->id) : 0  }} Sack</b>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="panel">
                    <header class="panel-heading panel-heading-blue text-center">
                        <strong>Weigh Per Pcs</strong>
                    </header>
                    <div class="panel-body text-center">
                        <b>{{ !empty($latestBatch) ? App\Helpers\Farmers::totalWeight($farmer->id) : 0 }} Kg</b> (Now)
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
                            <li class="nav-item">
                                <a href="#medicine" data-toggle="tab" class="active">Medicine</a>
                            </li>
                            <li class="nav-item">
                                <a href="#feed" data-toggle="tab">Feed</a>
                            </li>
                            <li class="nav-item">
                                <a href="#batch" data-toggle="tab">Batch Details</a>
                            </li>
                            <li class="nav-item">
                                <a href="#payments" data-toggle="tab">Payments Details</a>
                            </li>
                            <li class="nav-item">
                                <a href="#collections" data-toggle="tab">Collection Details</a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            {{-- Feed & Medicine --}}
                            <div class="tab-pane active" id="medicine">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body " style="">
                                            <div class="table-scrollable">
                                                @if(!$farmerInvoices->isEmpty())
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Medicine</th>
                                                            <th>Quantity</th>
                                                            <th>Cost</th>
                                                            <th>Memo No</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                        </thead>
                                                        <?php
                                                        $i =1;
                                                        $totalQuantity = 0;
                                                        $totalCost = 0;
                                                        ?>
                                                        <tbody>

                                                            @foreach($medicines as $medicine)
                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td>{{ Carbon::parse($medicine->date)->format('d-M-Y') }}</td>
                                                                    <td>{{ $medicine->product_name }}</td>
                                                                    <td>{{ $medicine->quantity }}</td>
                                                                    <td>{{ $medicine->total_selling }}</td>
                                                                    <td>{{ $medicine->receipt_no }}</td>
                                                                    <td>{{ $medicine->remarks }}</td>
                                                                </tr>
                                                                <?php
                                                                $totalQuantity += $medicine->quantity;
                                                                $totalCost += $medicine->total_selling;
                                                                ?>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="3">
                                                                <b>Total Summary</b>
                                                            </td>
                                                            <td>
                                                                <b>
                                                                    {{ $totalQuantity ?? 0 }}
                                                                </b>
                                                            </td>
                                                            <td>
                                                                <b>{{ number_format($totalCost,2,'.',',') ?? 0 }}</b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="feed">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body " style="">
                                            <div class="table-scrollable">
                                                @if(!$farmerInvoices->isEmpty())
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Feed</th>
                                                            <th>Quantity</th>
                                                            <th>Cost</th>
                                                            <th>Memo No</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                        </thead>
                                                        <?php
                                                        $i =1;
                                                        $totalQuantity = 0;
                                                        $totalCost = 0;
                                                        ?>
                                                        <tbody>
                                                            @foreach($feeds as $feed)
                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td>{{ Carbon::parse($feed->date)->format('d-M-Y') }}</td>
                                                                    <td>{{ $feed->product_name }}</td>
                                                                    <td>{{ $feed->quantity }}</td>
                                                                    <td>{{ $feed->total_selling }}</td>
                                                                    <td>{{ $feed->receipt_no }}</td>
                                                                    <td>{{ $feed->remarks }}</td>
                                                                </tr>
                                                                <?php
                                                                $totalQuantity += $feed->quantity;
                                                                $totalCost += $feed->total_selling;
                                                                ?>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="3">
                                                                <b>Total Summary</b>
                                                            </td>
                                                            <td>
                                                                <b>
                                                                    {{ $totalQuantity ?? 0 }}
                                                                </b>
                                                            </td>
                                                            <td>
                                                                <b>{{ number_format($totalCost,2,'.',',') ?? 0 }}</b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Batch Records--}}
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

                                                                        Status : <span class="btn btn-{{($farmerBatch->status === 'active')?'success':'danger' }}">{{ ($farmerBatch->status === 'active') ? 'Running' : 'Closed' }}</span>



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
                                                                        @if($farmerBatch->status === 'active')
                                                                            {{-- Add Todays Record Button --}}
                                                                            <a data-toggle="modal" data-target="#farmerRecordForm" class="btn btn-info btn-lg m-b-10">Add Todays Record</a>
                                                                        @endif
                                                                        @if($farmerBatch->status === 'inactive')
                                                                            {{--View FUll Record Button --}}
                                                                            <a href="{{ route('admin.fcr.download.pdf', $farmerBatch->batch_number) }}" class="btn btn-primary btn-lg m-b-10">Download FCR</a>@endif
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
                                                                        @foreach(\App\Helpers\Farmers::records($farmerBatch->batch_number) as $record)
                                                                            <tr class="text-center">
                                                                                <td>{{ $record->age }}</td>
                                                                                <td>{{ $record->child_death }}</td>
                                                                                <td>{{ $record->feed_eaten_kg }}</td>
                                                                                <td>{{ $record->feed_eaten_sack }} Sack</td>
                                                                                <td>{{ $record->feed_left }} Sack</td>
                                                                                <td>{{ $record->weight }}</td>
                                                                                <td style="max-width: 150px;">{{ $record->symtomp }}</td>
                                                                                <td style="max-width: 250px;">{{ $record->remarks }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                                <div class="fcr-calculation">
                                                                    <a href="{{ route('admin.farmer.fcr_calculate.page',$farmer->id) }}">
                                                                        @if($farmerBatch->status === 'active')
                                                                        <button class="btn btn-success">Generate FCR</button>
                                                                            @endif
                                                                    </a>
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

                            {{--Payments--}}
                            <div class="tab-pane" id="payments">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body " style="">
                                            <div class="table-scrollable">
                                                @if(!$payments->isEmpty())
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Bank Name</th>
                                                            <th>Type</th>
                                                            <th>Amount</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                        </thead>
                                                        <?php
                                                        $serial =1;
                                                        ?>
                                                        <tbody>

                                                        @foreach($payments as $payment)
                                                            <tr>
                                                                <td>{{ $serial++ }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-M-Y') }}</td>
                                                                <td>{{ $payment->bank->bank_name }}</td>
                                                                <td>
                                                                    {{ $payment->payment_type }}
                                                                </td>
                                                                <td>{{ $payment->payment_amount }}</td>
                                                                <td>{{ $payment->remarks ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach


                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="4">
                                                                <b>Total Paid Amount</b>
                                                            </td>
                                                            <td>
                                                                <b>{{ number_format($payments->sum('payment_amount'),2,'.',',') }}</b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--Collections--}}
                            <div class="tab-pane" id="collections">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body " style="">
                                            <div class="table-scrollable">
                                                @if(!$collections->isEmpty())
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Bank Name</th>
                                                            <th>Type</th>
                                                            <th>Amount</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                        </thead>
                                                        <?php
                                                        $serial =1;
                                                        ?>
                                                        <tbody>

                                                        @foreach($collections as $collection)
                                                            <tr>
                                                                <td>{{ $serial++ }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($collection->collection_date)->format('d-M-Y') }}</td>
                                                                <td>{{ $collection->bank->bank_name }}</td>
                                                                <td>
                                                                    {{ $collection->collection_type }}
                                                                </td>
                                                                <td>{{ $collection->collection_amount }}</td>
                                                                <td>{{ $collection->remarks ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach


                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="4">
                                                                <b>Total Collection Amount</b>
                                                            </td>
                                                            <td>
                                                                <b>{{ number_format($collections->sum('collection_amount'),2,'.',',') }}</b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                @endif
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
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
<!-- data tables -->
<script src="{{ asset('admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js') }}" ></script>
<!-- data time -->
<script src="{{ asset('admin/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"  charset="UTF-8"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker-init.js') }}"  charset="UTF-8"></script>
{{--<script src="{{ asset('admin/assets/js/pages/table/table_data.js') }}" ></script>--}}
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

<script src="{{ asset('js/daily-record-form.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#daily-reports").hide();
        $("#daily-reports-button").click(function () {
            $("#daily-reports").toggle('slow');
        });
    })
</script>

@endpush
