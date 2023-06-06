<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use App\Models\Customer;
use App\Models\Order;

class CustomerController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        $customers = Customer::all();
        
        return response()->json($customers);
    }
    

    public function create(Request $request)
    {
        // 
    }

    public function store(Request $request)
    {
        $customer = Customer::create($request->all());

        return response()->json($customer, 201);
    }

    public function show()
    {
        $customers = Customer::all();
    
        return response()->json($customers);
    }
    
    public function edit(Request $request, Customer $customer)
    {
        $customer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact_information' => $request->input('contact_information'),
        ]);

        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact_information' => $request->input('contact_information'),
        ]);
    
        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response('success', 201);
    }
}
