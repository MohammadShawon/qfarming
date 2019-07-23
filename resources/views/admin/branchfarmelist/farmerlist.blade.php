<?php
    use Carbon\Carbon;
?>
@extends('template.app')

@section('title', 'Branch Farmers')

@push('css')
    <!-- data tables -->
    <link href="{{ asset('admin/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css')}} " rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="page-bar">
        <div class="page-title-breadcrumb">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.farmer.create') }}" id="addRow1" class="btn btn-primary" 
                    style="font-size:14px; padding: 6px 12px;">
                        Add New Farmer <i style="color:white;" class="fa fa-plus"></i>
                    </a>
                    
                </div>
                <div class="btn-group pull-right">
                        <button class="btn deepPink-bgcolor  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-print"></i> Print </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                            </li>
                        </ul>
                </div>
                <div class="card card-box">
                    <div class="card-head" style="text-align: center;">
    {{--                    <header>FARMER</header> <span class="btn btn-primary ml-1"> {{ $farmers->count() }} </span>--}}
                        <header>Branch Farmer List</header>

                    </div>
                    <div class="card-body">

                           {{-- {!! $dataTable->table(['class' => 'display','style' => 'width: 100%','id' => 'dataTable' ]) !!} --}}

                    </div>
                </div>
        </div>
    </div>
@endsection

@push('js')
{{--    <script src="{{ asset('https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js') }}"></script>--}}
    <script src="{{ asset('admin/assets/plugins/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('admin/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js') }}" ></script>
<script src="{{ asset('admin/assets/js/buttons/dataTables.buttons.min.js') }}"></script>
    {{-- <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!} --}}


    

    <!-- sweet aleart -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script type="text/javascript">
    
    function deleteFarmer(id) {

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
                'Your SubCategory name is safe :)',
                'error'
                )
            }
        })

    }
    
    </script>
@endpush
