<?php

namespace App\Http\Controllers\Admin;

use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Http\Requests\Farmer\FarmerStoreRequest;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Farmer\FarmerUpdateRequest;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farmers = Farmer::latest()->get();
        return view('admin.farmer.index', compact('farmers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::all();
        return view('admin.farmer.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FarmerStoreRequest $request)
    {
        /* Insert Farmer */
        $farmer = Farmer::create([
            'branch_id'        =>      $request->branch,
            'name'             =>      $request->name,
            'phone1'           =>      $request->phone1,
            'phone2'           =>      $request->phone2,
            'email'            =>      $request->email,
            'address'          =>      $request->address,
            'opening_balance'  =>      $request->opening_balance,
            'starting_date'    =>      Carbon::parse($request->starting_date)->format('Y-m-d H:i'),
            'ending_date'      =>      Carbon::parse($request->ending_date)->format('Y-m-d H:i'),
            'status'           =>      'active',
        ]);
        /* Check famer insertion  and Toastr */
        if($farmer){
            Toastr::success('Farmer Inserted Successfully', 'Success');
            return redirect()->route('admin.farmer.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function show(Farmer $farmer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function edit(Farmer $farmer)
    {
        $branches = Branch::all();
        return view('admin.farmer.edit', compact('farmer', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function update(FarmerUpdateRequest $request, Farmer $farmer)
    {
        /* update Farmer */
        $resultFarmer = $farmer->update([
            'branch_id'        =>      $request->branch,
            'name'             =>      $request->name,
            'phone1'           =>      $request->phone1,
            'phone2'           =>      $request->phone2,
            'email'            =>      $request->email,
            'address'          =>      $request->address,
            'opening_balance'  =>      $request->opening_balance,
            'starting_date'    =>      Carbon::parse($request->starting_date)->format('Y-m-d H:i'),
            'ending_date'      =>      Carbon::parse($request->ending_date)->format('Y-m-d H:i'),
            'status'           =>      'active',
        ]);
        /* Check famer insertion  and Toastr */
        if($farmer){
            Toastr::success('Farmer Updated Successfully', 'Success');
            return redirect()->route('admin.farmer.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farmer $farmer)
    {
        $farmer->delete();
        Toastr::success('Farmer Deleted Successfully', 'Success');
        return redirect()->route('admin.farmer.index');
    }
}
