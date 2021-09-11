<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use App\Models\FoodCollection;
use App\Models\FoodRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FoodCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = FoodCollection::latest()->get();
        return view('food_collections.index',compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requests = FoodRequest::where([
            ['trash','=',1],
            ['status','=','approved'],
            ['issued_on','=',null],
            ['type','=','food']
            ])
            ->orWhere([
                ['trash','=',1],
                ['status','=','approved'],
                ['type','=','extra']
                ])->get();

        return view('food_collections.create',compact('requests'));
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
            'paynumber' => 'required',
            'jobcard' => 'required',
            'frequest' => 'required|unique:food_collections,frequest',
            'issue_date' => 'required',
            'iscollector' => 'required',
            'pin' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();

        } else {

            try {

                $frequest = FoodRequest::findOrFail($request->paynumber);

                $user = User::where('paynumber',$frequest->paynumber)->first();

                $collect = new FoodCollection();
                $collect->paynumber = $user->paynumber;
                $collect->jobcard = $request->input('jobcard');
                $collect->frequest = $request->input('frequest');

                if ($frequest->type == "food")
                {
                    if (!empty($request->allocation))
                    {
                        $collect->allocation = $request->input('allocation');

                    } else {

                        return redirect()->back()->with('error','User has no allocation');
                    }

                }

                if ($frequest->type == "extra")
                {
                    $collect->allocation = "Extra-".$frequest->id;
                }

                $collect->issue_date = $request->input('issue_date');

                if ($request->iscollector == 'self')
                {
                    $collect->self = 1;

                } else {
                    $id_number = $request->collected_by;

                    if($id_number)
                    {
                        $beneficiary = Beneficiary::where('id_number',$id_number)->first();
                        $collect->self = 0;
                        $collect->collected_by = $beneficiary->full_name;
                        $collect->id_number = $beneficiary->id_number;

                    } else {

                        return redirect()->back()->with("error","Please select employee beneficiary");
                    }
                }

                if (Hash::check($request->pin,$user->pin))
                {
                    $collect->done_by = Auth::user()->id;
                    $collect->updated_at = now();
                    $collect->status = 1;
                    $collect->save();

                    if ($collect->save())
                    {
                        $frequest->status = "collected";
                        $frequest->issued_on = now();
                        $frequest->save();

                        if ($frequest->type == "food")
                        {
                            $allocation = Allocation::where('allocation',$request->allocation)->first();
                            $allocation->food_allocation -= 1;
                            $allocation->status = "collected";
                            $allocation->save();

                            $user->fcount -= 1;
                            $user->save();
                        }

                    }

                    return redirect('fcollections/create')->with('success','Collection has been processed successfully');
                }

            } catch (\Exception $e) {
                echo "error - ".$e;
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
        $collection = FoodCollection::findOrFail($id);

        return view('food_collections.show',compact('collection'));
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
        //
    }

    public function getFoodRequest($id)
    {
        $data = DB::table("food_requests")
          ->where("id",$id)
          ->pluck("request");

        return response()->json($data);
    }

    public function getFoodRequestAllocation($id)
    {
        $allocation = DB::table("food_requests")
          ->where("id",$id)
          ->pluck("allocation");

        return response()->json($allocation);
    }

    public function getUserBeneficiaries($id)
    {
        $request = FoodRequest::where('id',$id)->first();

        $user = User::where('paynumber',$request->paynumber)->first();

        $beneficiaries = DB::table('beneficiaries')
                            ->where('user_id','=',$user->id)
                            ->pluck('first_name','id_number');

        return response()->json($beneficiaries);
    }

    public function getRequestJobcard($id)
    {
        $jobcard = DB::table("food_requests")
          ->where("id",$id)
          ->pluck("jobcard");

        return response()->json($jobcard);
    }
}
