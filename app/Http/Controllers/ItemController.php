<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\select;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        // $items = DB::table('m_item')->get();
        return view('items.index', ['items' => $items]);
        // return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $user = DB::table('users')->where('id', Auth::id())->first();

    $request->validate([
        'code' => ['required', Rule::unique('m_item')->whereNull('deleted_at')],
        'name' => 'required'
    ]);

    try {
        DB::beginTransaction();

        $data = new Item();
        $data->code = $request->code;
        $data->name = $request->name;
        $data->create_who = $user->name; 
        $data->updated_at = null;
        $data->save();

        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'Item created successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Failed to create item: ' . $e->getMessage()], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::find($id);
        return view('items.show', ['item'=>$item]); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::find($id);
        // dd($item);
        if($item){
           return response()->json(['status' => 'success', 'data' => $item]);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Item Not found ! ']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    $user = DB::table('users')->where('id', Auth::id())->first();

    $request->validate([
       'code' => [
            'required', Rule::unique('m_item')->ignore($id)->whereNull('deleted_at')],
        'name' => 'required'
    ]);

    try {
        DB::beginTransaction();

        $item = Item::find($id);
        if ($item) {
            $item->code = $request->code;
            $item->name = $request->name;
            $item->change_who = $user->name;
            $item->save();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Item updated successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Item not found'], 404);
        }
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Failed to update item: ' . $e->getMessage()], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    try {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json(['status' => 'success', 'message' => 'Item deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to delete item: ' . $e->getMessage()], 500);
    }
}

}
