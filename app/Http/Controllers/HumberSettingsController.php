<?php

namespace App\Http\Controllers;

use App\Models\HumberSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HumberSettingsController extends Controller
{

    public function getSettings(){
        $humber = HumberSetting::findOrFail(1);
        return view('hsettings.hsettings',compact('humber'));
    }

    public function updateSettings(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'food_available' => 'required',
            'meat_available' => 'required',
            'last_agent' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            try {

                $hsetting = HumberSetting::findOrFail($id);
                $hsetting->food_available = $request->food_available;
                $hsetting->meat_available = $request->meat_available;
                $hsetting->last_agent = $request->last_agent;
                $hsetting->save();

                return redirect('home')->with('success','System settings has been updated successfully');

            } catch (\Exception $e) {
                echo "Error - ".$e;
            }
        }
    }
}
