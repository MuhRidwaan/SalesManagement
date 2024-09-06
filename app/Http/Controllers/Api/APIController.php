<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;

class APIController extends Controller
{
    public function getItems()
    {
        $items = Item::all();
        // return response()->json(['data' =>$items]);
        return ItemResource::collection($items);
    }
}
