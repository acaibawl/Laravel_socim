<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function getCustomers(CustomerService $service)
    {
        return response()->json($service->getCustomers());
    }

    public function postCustomers(Request $request, CustomerService $service)
    {
        $this->validate($request, ['name' => 'required']);
        $service->addCustomer($request->json('name'));
    }
}
