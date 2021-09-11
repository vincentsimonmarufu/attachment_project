<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeneficiariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beneficiaries = Beneficiary::all();
        return view('beneficiaries.index',compact('beneficiaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('beneficiaries.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'id_number' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();

        } else {
            try {

                $beneficiary_exist = Beneficiary::where('id_number',$request->id_number)->first();

                if (!$beneficiary_exist)
                {
                        // create or add beneficiaries
                        $beneficiary = new Beneficiary();
                        $beneficiary->first_name = $request->first_name;
                        $beneficiary->last_name = $request->last_name;
                        $beneficiary->mobile_number = $request->mobile_number;
                        $beneficiary->id_number = $request->id_number;
                        $beneficiary->save();

                    return redirect('beneficiaries')->with('success','New beneficiary has been added successfully');

                } else {

                    return back()->with("error","Please not that the beneficary account already exist.. Proceed to asign beneficiary to another user.");
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $beneficiary->delete();

        return redirect('beneficiaries')->with('success','Beneficiary has been deleted successfully.');
    }

    public function assignBeneficiary()
    {
        $users = User::all();
        $beneficiaries = Beneficiary::latest()->get();
        return view('beneficiaries.assign-beneficiary',compact('users','beneficiaries'));
    }

    public function getIdNumber()
    {
        
    }
}
