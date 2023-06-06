<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\ApiLink;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class ApiService
{
    public function getCustomers()
    {
        $apiUrls = ApiLink::pluck('url')->toArray();

        foreach ($apiUrls as $apiUrl) {
            $response = (new Client())->get($apiUrl);
            $customersData = json_decode($response->getBody(), true);

            foreach ($customersData as $customerData) {
                $validator = Validator::make(['email' => $customerData['email']], [
                    'email' => 'required|unique:customers,email',
                ]);

                if ($validator->fails()) {
                    continue;
                }

                $customer = new Customer();
                $customer->name = $customerData['name'];
                $customer->email = $customerData['email'];
                $customer->contact_information = json_encode($customerData['address']);
                $customer->save();
            }
        }
    }

    public function getCustomerOrders()
    {
        $customer = Customer::with('orders')->get();

        return response()->json($customer);
    }
    
    
    
}
