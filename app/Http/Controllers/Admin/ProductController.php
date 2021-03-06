<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Product\ProductsDataTable;
use App\Models\Company;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Http\Requests\Product\ProductStoreRequest;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Unit;
use \DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductsDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $dataTable)
    {

        /* Product List */
        if(auth()->user()->can('view_product')){
//            $products = Product::latest()->get();
//            return view('admin.product.index', compact('products'));
            return $dataTable->render('admin.product.index');
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* Product Create form */
        if(auth()->user()->can('create_product')){
            $data['subCategories'] = SubCategory::get(['id','name']);
            $data['baseUnits'] = Unit::get(['id','name']);
            $data['companies'] = Company::get(['id','name']);
            return view('admin.product.create', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        /* Product Store */
        if(auth()->user()->can('create_product')){
            DB::beginTransaction();
            try{
                $product = Product::create([
                    'subcategory_id' => $request->input('sub_category'),
                    'product_name'   => $request->input('product_name'),
                    'company_id'     => $request->input('company_id'),
                    'sku'            => $request->input('sku'),
                    'barcode'        => $request->input('barcode'),
                    'base_unit_id'   => $request->input('unit_id'),
                    'description'    => $request->input('description'),
                    'size'           => $request->input('size'),
                    'created_at'     => Carbon::now('+6'),
                    'updated_at'     => Carbon::now('+6')
//                  'cost_price'      => $request->cost_price,
//                   'selling_price'  => $request->selling_price,
//                   'quantity'       => $request->quantity,
                ]);
            }catch (\Exception $e)
            {

                DB::rollback();
                Toastr::success('Something Went Wrong 1', 'Error');
                return redirect()->route('admin.product.create');
            }

            /*
             * Process Batch No
             * */

            try{
                $batch = new ProductPrice([
                    'product_id'       =>      $product->id,
                    'branch_id'       =>      auth()->user()->branch_id,
                    'batch_no'         =>      date('Y'). '-'.random_int(1,50000),
                    'quantity'         =>      $request->quantity,
                    'sold'             =>      0,
                    'cost_price'       =>      $request->cost_price,
                    'selling_price'    =>      $request->selling_price,
                    'mfg_date'         =>      Carbon::now('+6'),
                    'exp_date'         =>      Carbon::now('+6'),
                    'created_at'       =>       Carbon::now('+6'),
                    'updated_at'        =>      Carbon::now('+6'),

                ]);
                $product->productprices()->save($batch);
            }catch (\Exception $e)
            {
                DB::rollback();
                Toastr::success('Something Went Wrong 2', 'Error');
                return redirect()->route('admin.product.create');
            }

            /*
             * Inventories Process
             * */

            try
            {
                $inventories = Inventory::create([
                    'product_id'    => $product->id,
                    'user_id'       => auth()->user()->id,
                    'branch_id'     => auth()->user()->branch_id,
//                    'batch_no'      => $batch->batch_no,
                    'unit_id'       => $request->unit_id,
                    'in_out_qty'    => $request->quantity,
                    'remarks'       => 'OpeningStock',
                    'created_at'    => Carbon::now('+6.30'),
                    'updated_at'    => Carbon::now('+6.30'),
                ]);
            }catch (\Exception $e)
            {
                DB::rollback();
                Toastr::success('Something Went Wrong 3', 'Error');
                return redirect()->route('admin.product.create');
            }

            DB::commit();

            /* Check Product store and toastr message */
            if($product && $batch && $inventories){

                Toastr::success('Product Successfully Added', 'Success');
                return redirect()->route('admin.product.index');
            }
            abort(404);
        } else{
            return redirect('login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        /* Single Product Details */
        if(auth()->user()->can('view_product')){
            return view('admin.product.show', compact('product'));
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        /* Product Edit form */
        if(auth()->user()->can('edit_product')){

            $data['subCategories'] = SubCategory::get(['id','name']);
            $data['companies'] = Company::get(['id','name']);
            return view('admin.product.edit', $data, compact('product'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        /* Product Update */
        if(auth()->user()->can('edit_product')){

            $productResult = $product->update([
                'subcategory_id' => $request->input('sub_category'),
                'product_name'   => $request->input('product_name'),
                'company_id'     => $request->input('company_id'),
                'sku'            => $request->input('sku'),
                'barcode'        => $request->input('barcode'),
                'base_unit_id'   => $request->input('unit_id'),
                'description'    => $request->input('description'),
                'size'           => $request->input('size'),
                'cost_price'     => $request->input('cost_price'),
                'selling_price'  => $request->input('selling_price'),
                'quantity'       => $request->input('quantity'),
            ]);
            /* Check Product Update and toastr message */
            if($productResult){
                Toastr::success('Product Successfully Updated', 'Success');
                return redirect()->route('admin.product.index');
            }
            abort(404);
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        /* DELETE Product */
        if(auth()->user()->can('delete_product')){

            $deleteProduct = $product->delete();
            if($deleteProduct){
                Toastr::success('Product Successfully Deleted', 'Success');
                return redirect()->route('admin.product.index');
            }
            abort(404);
        }
        abort(403);
    }
}
