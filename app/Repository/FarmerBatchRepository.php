<?php


namespace App\Repository;


use App\Models\FarmerBatch;

class FarmerBatchRepository
{
    /**
     * @var FarmerBatch
     */
    private $model;

    /**
     * FarmerBatchRepository constructor.
     * @param FarmerBatch $model
     */
    public function __construct(FarmerBatch $model)
    {

        $this->model = $model;
    }

    public function currentBatch($farmer_id)
    {
        return $this->model->where('farmer_id', $farmer_id)->where('status','active')->first();
    }

    public function updateActiveBatch($farmer_id, $batch_number)
    {
        $batch = $this->model->where('farmer_id', $farmer_id)->where('batch_number', $batch_number)->first();
        $batch->status = 'inactive';
        $batch->save();
        return $batch;
    }


}
