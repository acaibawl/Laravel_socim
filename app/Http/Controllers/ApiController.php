<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function getCustomers()
    {
        return response()->json(Customer::query()->select(['id', 'name'])->get());
    }

    public function postCustomers(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $customer = new Customer();
        $customer->name = $request->json('name');
        $customer->save();
    }
}
