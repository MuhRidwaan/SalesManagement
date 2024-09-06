<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Group;
use App\Models\Uom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory = DB::table('m_inventory as a')
        ->join('m_group as b', 'a.group_id', '=' , 'b.id')
        ->join('m_item as c', 'a.item_id', '=', 'c.id')
        ->join('m_uom as d', 'a.uom_id', '=', 'd.id')
        ->select('a.*','b.name as group_name', 'c.name as item_name', 'd.name as uom_name')
        ->get();
        return view('inventory.index', ['inventory' => $inventory]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $groups = Group::all();
        $uoms = uom::all();
        return view('inventory.create', ['items' => $items, 'groups'=>$groups , 'uoms' => $uoms ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = DB::table('users')->where('id', Auth::id())->first();
        $request->validate([
            'group_id' => 'required',
            'item_id' => 'required',
            'uom_id' => 'required',
            'entry_date' => 'required|date_format:Y-m-d',
            'expiry_date' => 'nullable|date_format:Y-m-d',
            'stock_quantity' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric'
        ]);

        try{
            DB::beginTransaction();

            $data = new Inventory();
            $data->group_id = $request->group_id;
            $data->item_id= $request->item_id;
            $data->uom_id= $request->uom_id;
            $data->description= $request->description;
            $data->entry_date= $request->entry_date;
            $data->expiry_date= $request->expiry_date;
            $data->stock_quantity= $request->stock_quantity;
            $data->purchase_price= $request->purchase_price;
            $data->sale_price= $request->sale_price;
            $data->minimum_stock= $request->minimum_stock;
            $data->supplier= $request->supplier;
            $data->order_quantity= $request->order_quantity;
            $data->sold_quantity= $request->sold_quantity;
            $data->notes= $request->notes;
            $data->created_who = $user->name;
            $data->updated_at = null;

            $data->save();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'You have successfully Created Data Inventory']);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Failed to Create inventory' . $e->getMessage()], 500);
        }
    }

  
    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id)
{
    $inventory = Inventory::findOrFail($id);
    $items = Item::all();
    $groups = Group::all();
    $uoms = Uom::all();

    return view('inventory.edit', compact('inventory', 'items', 'groups', 'uoms'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
        $user = DB::table('users')->where('id', Auth::id())->first();
        $request->validate([
            'group_id' => 'required',
            'item_id' => 'required',
            'uom_id' => 'required',
            'entry_date' => 'required|date_format:Y-m-d',
            'expiry_date' => 'nullable|date_format:Y-m-d',
            'stock_quantity' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $data = Inventory::findOrFail($id);
            $data->group_id = $request->group_id;
            $data->item_id = $request->item_id;
            $data->uom_id = $request->uom_id;
            $data->description = $request->description;
            $data->entry_date = $request->entry_date;
            $data->expiry_date = $request->expiry_date;
            $data->stock_quantity = $request->stock_quantity;
            $data->purchase_price = $request->purchase_price;
            $data->sale_price = $request->sale_price;
            $data->minimum_stock = $request->minimum_stock;
            $data->supplier = $request->supplier;
            $data->order_quantity = $request->order_quantity;
            $data->sold_quantity = $request->sold_quantity;
            $data->notes = $request->notes;
            $data->change_who = $user->name;
            $data->updated_at = now();

            $data->save();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'You have successfully updated data inventory']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Failed to update inventory: ' . $e->getMessage()], 500);
        }
    }

      /**
     * Display the specified resource.
     */
 public function show($id)
{
    $inventory = DB::table('m_inventory as a')
        ->join('m_group as b', 'a.group_id', '=', 'b.id')
        ->join('m_item as c', 'a.item_id', '=', 'c.id')
        ->join('m_uom as d', 'a.uom_id', '=', 'd.id')
        ->select(
            'a.*',
            'b.name as group_name',
            'c.name as item_name',
            'd.name as uom_name'
        )
        ->where('a.id', $id)
        ->first();  // Use first() to get a single record

    if (!$inventory) {
        abort(404, 'Inventory not found'); // Handle not found scenario
    }

    return view('inventory.show', ['inventory' => $inventory]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
