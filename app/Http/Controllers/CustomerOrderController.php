<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index(Customer $customer)
    {
        $orders = $customer->orders;

        return response()->json($orders);
    }
}
