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
            ->addColumn('action',function ($data){
                return "<a class='waves-effect btn btn-success' data-value='$data->id' href='{{ route('admin.farmer.show', $data->id) }}'><i class='material-icons'>visibility</i></a> 
                        <a class='waves-effect btn btn-primary' data-value='$data->id' href='{{ route('admin.farmer.edit', $data->id) }}'><i class='material-icons'>edit</i></a>
                        <button class='waves-effect btn deepPink-bgcolor' data-value='$data->id' ><i class='material-icons'>delete</i></button>";
            })
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
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
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
                'title' => 'Alt. Number'
            ],
            [
                'data'  => 'opening_balance',
                'name'  => 'opening_balance',
                'title' => 'Open Balance',
            ],
            [
                'data'  => 'status',
                'name'  => 'Status',
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
    protected function getBuilderParameters()
    {
        return parent::getBuilderParameters(); // TODO: Change the autogenerated stub
    }
}
