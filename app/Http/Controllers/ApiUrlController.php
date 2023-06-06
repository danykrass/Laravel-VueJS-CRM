<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiLink;
use App\Services\ApiService;

class ApiUrlController extends Controller
{
    private $apiService; 

    public function __construct(ApiService $apiService) 
    {
        $this->apiService = $apiService;
    }
    public function fetchApiUrls()
    {
        $links = ApiLink::all();

        return response()->json($links, 200);
    }
    public function saveApiUrls(Request $request)
    {
        $apiUrls = $request->input('apiUrls');

        ApiLink::truncate();

        foreach ($apiUrls as $api) {
            ApiLink::create($api);
        }

        return response()->json(['success' => true]);
    }

    public function fetchCustomers()
    {
        $this->apiService->getCustomers(); 

        return response()->json(['success' => true]);
    }
}

