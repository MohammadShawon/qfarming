<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PurchasetempItem extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;

	protected $fillable = [
        'user_id',
        'product_id',
        'batch_no',
        'cost_price',
        'discount',
        'unit_id',
        'quantity',
        'total_cost',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
