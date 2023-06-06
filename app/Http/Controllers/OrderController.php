<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ApiService;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        $orders = Order::with('customer')->get();

        return response()->json($orders);
    }

    public function create(Customer $customer)
    {
        //
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'details' => 'required',
            'status' => 'required',
            'customer_id' => 'required',
        ]);

        $name = $request->input('customer_id');
        $customer = Customer::where('name', $name)->first();

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        $order = new Order([
            'customer_id' => $customer->id,
            'details' => $request->input('details'),
            'status' => $request->input('status'),
            'due_date' => $request->input('due_date') == 'null' ? null : Carbon::parse($request->input('due_date')),
        ]);
    
        if ($request->hasFile('files')) {
            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store("orders/files/customer_{$order->customer->id}/order_{$order->id}");
                $uploadedFiles[] = $path;
            }
            $order->files = json_encode($uploadedFiles);
        }

        $order->save();
    
        return response()->json($order);
    }
    
    private function parseDate($dateString)
    {
        $date = DateTime::createFromFormat('D M d Y H:i:s e', $dateString);
        return $date ? Carbon::instance($date) : null;
    }
    
    public function show(Customer $customer)
    {
        $customer = $this->apiService->getCustomerOrders($customer->id);

        return response()->json($customer);
    }
    
    public function edit(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'details' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $order->update([
            'details' => $request->input('details'),
            'status' => $request->input('status'),
            'due_date' => $request->input('due_date') == 'null' ? null : Carbon::parse($request->input('due_date')),
        ]);

        return response()->json($order);
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'details' => 'required',
            'status' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $order->update([
            'details' => $request->input('details'),
            'status' => $request->input('status'),
            'due_date' => $request->input('due_date') == 'null' ? null : Carbon::parse($request->input('due_date')),
        ]);

        if ($request->hasFile('files')) {
            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store('orders/files/customer_'.$order->customer->id.'/order_'.$order->id);
                $uploadedFiles[] = $path;
            }
            $order->files = json_encode($uploadedFiles);
            $order->save();
        }

        return response()->json($order);
    }
    

    public function destroy(Order $order)
    {
        $order->delete();

        return response('success', 201);
    }

    public function fetchOrders(Request $request)
    {

        $apiOrders = $this->apiService->fetchOrders();

        $orders = collect($apiOrders)->map(function ($apiOrder) {
            return [
                'id' => $apiOrder['id'],
                'name' => $apiOrder['name'],
                'title' => $apiOrder['title'],
            ];
        });

        return response()->json($orders);
    }
    
}
