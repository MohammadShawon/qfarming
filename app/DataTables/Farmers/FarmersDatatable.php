<?php

namespace App\DataTables\Farmers;

use App\Models\Farmer;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html;
use Yajra\DataTables\DataTables;

class FarmersDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addIndexColumn()
            ->editColumn('branch_id',function ($farmer)
            {
                return $farmer->branch->name;
            })
            ->editColumn('status',function ($status){
                return $this->getStatus($status);
            })
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['status','action'])
            ->setRowClass('gradeX');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Farmer $model)
    {
        return $model->newQuery()->select('id', 'branch_id','name','phone1','phone2','address','opening_balance','starting_date','ending_date','status', 'created_at', 'updated_at');
    }

    /**
     * @param $status
     * @return string
     */
    protected function getStatus($status):string
    {
        if ($status->status === 'active'){
            return "<span class='btn btn-circle btn-success'> Active </span>";
        }
        elseif ($status->status === 'inactive'){
            return "<span class='btn btn-circle btn-danger'> InActive </span>";
        }else
        {
            return "<span class='btn btn-circle btn-danger disabled'> Disabled </span>";
        }

    }

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $showUrl = route('admin.farmer.show', $data->id);
        $editUrl = route('admin.farmer.edit', $data->id);
        return "<a class='waves-effect btn btn-success' data-value='$data->id' href='$showUrl'><i class='material-icons'>visibility</i>Details</a> 
                        <a class='waves-effect btn btn-primary' data-value='$data->id' href='$editUrl'><i class='material-icons'>edit</i>Update</a>
                        <button class='waves-effect btn deepPink-bgcolor delete' data-value='$data->id' ><i class='material-icons'>delete</i>Delete</button>";
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->addIndex()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '30%'])
                    ->paging(true)
                    ->lengthMenu([[50, 100,500, -1], [50, 100,500, 'All']])
                    ->parameters($this->getBuilderParameters())
                    ->scrollX(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [

            [
                'data' => 'branch_id',
                'name' => 'branch_id',
                'title' => 'Branch Name',
                'searchable' => true,
                'visible' => true,
                'orderable' => true
            ],
            [
                'data'  => 'name',
                'name'  => 'name',
                'title' => 'Farmer Name',
            ],
            [
                'data'  => 'phone1',
                'name'  => 'phone1',
                'title' => 'Phone Number'
            ],
            [
                'data'  => 'phone2',
                'name'  => 'phone2',
                'title' => 'Alt. Number',
                'visible' => false
            ],
            [
                'data'  => 'opening_balance',
                'name'  => 'opening_balance',
                'title' => 'Open Balance',
            ],
            [
                'data'  => 'status',
                'name'  => 'status',
                'title' => 'Status',
            ],
            
        ];
    }



    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Farmers/Farmers_' . date('YmdHis');
    }

    /**
     * @return array
     */
    protected function getBuilderParameters():array
    {
        return[
            'dom'     => 'Blfrtip',
            'order'   => [[0, 'desc']],
            'buttons' => [
                'create',
                'export',
                'print',
            ],
        ];
    }
}
