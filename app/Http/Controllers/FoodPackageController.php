<?php

namespace App\Http\Controllers;

use App\Models\type_coupons;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FoodPackageController extends Controller
{
    public function insert_food_package(Request $request)
    {
        $role = [
           'name' => 'required|string',
           'description' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $role);
        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            )); // 400 being the HTTP code for an invalid request.
        }

        $data = $request->all();


        $results = type_coupons::create($data);
       // dd($results);
        return Response::json(array('success' => true,'results'=>$results));
    }

    public function food_coupons(Request $request)
    {
        return view('food_coupons');

    }
    public function getCouponsInfo(Request $request)
    {
        $role = [

        ];
    //$data = $request->validate($role);
    $query = type_coupons::get();
  // dd($query);
    $result['data'] = [];
    if ($query) {

        foreach ($query as $key => $value) {

            $result['data'][] = array(
                $value['id'],
                $value['name'],
                $value['description'],
            );
        }
    }
    echo json_encode($result);
}
}
