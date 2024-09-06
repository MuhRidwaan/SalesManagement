<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return view('group.index', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $user = DB::table('users')->where('id', Auth::id())->first();
         

    $request->validate([
        'code' => ['required', Rule::unique('m_group')->whereNull('deleted_at')],
        'name' => 'required'
    ]);
    

    try {
        DB::beginTransaction();

        $data = new Group();
        $data->code = $request->code;
        $data->name = $request->name;
        $data->created_who = $user->name; 
        $data->updated_at = null;
        $data->save();

        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'Group created successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Failed to create Group: ' . $e->getMessage()], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::find($id);
        return view('group.show', ['group'=>$group]); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $group = Group::find($id);
        if($group){
           return response()->json(['status' => 'success', 'data' => $group]);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Item Not found ! ']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = DB::table('users')->where('id', Auth::id())->first();

    $request->validate([
       'code' => [
            'required', Rule::unique('m_group')->ignore($id)->whereNull('deleted_at')],
        'name' => 'required'
    ]);

    try {
        DB::beginTransaction();

        $group = Group::find($id);
        if ($group) {
            $group->code = $request->code;
            $group->name = $request->name;
            $group->change_who = $user->name;
            $group->save();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Group updated successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Group not found'], 404);
        }
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Failed to update item: ' . $e->getMessage()], 500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
        $group = Group::findOrFail($id);
        $group->delete();

        return response()->json(['status' => 'success', 'message' => 'Group deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to delete Group: ' . $e->getMessage()], 500);
    }
    }
}
