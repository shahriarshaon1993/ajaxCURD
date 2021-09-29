<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountriesController extends Controller
{
    /**
     * index for show
     * countries lists
     *
     * @return void
     */
    public function index()
    {
        return view('countries-lists');
    }

    /**
     * for add Country
     *
     * @param  mixed $request
     * @return void
     */
    public function addCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|unique:countries',
            'capital_city' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $country = new Country();
            $country->country_name = $request->country_name;
            $country->capital_city = $request->capital_city;
            $query = $country->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went worng']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'New country has been successfully saved']);
            }
        }
    }
}
