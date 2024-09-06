<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Exception;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;
use Illuminate\Validation\Rule;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $uoms = DB::table('m_uom')->get();
        $uoms = Uom::all();
        return view('uoms.index', ['uoms' => $uoms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = DB::table('users')->where('id', Auth::id())->first();

        $request->validate([
            'code' => ['required', Rule::unique('m_uom')->whereNull('deleted_at')],
            'name' => 'required'
        ]);

        try{
            DB::beginTransaction();

            $data = New Uom();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->created_who = $user->name;
            $data->updated_at = null;


            // print_r($data);

            $data->save();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Satuan Berhasil Di buat']);
        }catch(\Exception $e){
            DB::rollBack();
            // return response()->json(['status' => 'error', 'message' => 'Gagal membuat Satuan']);
              return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat Satuan: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $uom = Uom::find($id);
        return view('uoms.show', ['uom' => $uom]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $uom = Uom::find($id);
        if($uom){
           return response()->json(['status' => 'success', 'data' => $uom]);
        }else{
            return response()->json(['status' => 'error', 'message' => 'uom Not found ! ']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $user = DB::table('users')->where('id', Auth::id())->first();

    $request->validate([
        'code' => ['required', Rule::unique('m_uom')->ignore($id)->whereNull('deleted_at')],
        'name' => 'required'
    ]);

    // print_r($request);

    try {
        DB::beginTransaction();

        $uom = Uom::find($id);
        if ($uom) {
            $uom->code = $request->code;
            $uom->name = $request->name;
            $uom->change_who = $user->name;
            $uom->save();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Uom updated successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Uom not found'], 404);
        }
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Failed to update Uom: ' . $e->getMessage()], 500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        $uom = Uom::findOrFail($id);
        $uom->delete();

        return response()->json(['status' => 'success', 'message' => 'Item deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to delete item: ' . $e->getMessage()], 500);
    }
}
}
