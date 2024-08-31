<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CustomersRequest;
use App\Models\Customer;
use App\Models\Commune;
use App\Models\Log;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            if(!$request->dni && !$request->email){
                return response()->json([
                    'success' => false,
                    'message' => 'There are no parameters to perform a search'
                ], 500);
            }

            $customers = Customer::join('communes', 'communes.id_com', 'customers.id_com')
            ->join('regions', 'regions.id_reg', 'customers.id_reg')
            ->where('dni', $request->dni)
            ->orWhere('email', $request->email)
            ->select('dni', 'name', 'last_name', 'address', 'communes.description as description_commune', 'regions.description as description_region', 'customers.status as status_customer')
            ->get();

            $customers = $customers->filter(function($item) use($request) {
                return $item->status_customer == 'A';
            });

            return response()->json([
                'success' => true,
                'data' => $customers
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }

    public function store(CustomersRequest $request)
    {
        $existRelation = Commune::join('regions', 'regions.id_reg', 'communes.id_reg')
        ->where('regions.id_reg', $request->id_reg)
        ->where('communes.id_com', $request->id_com)
        ->exists();

        if(!$existRelation){
            return response()->json([
                'success' => false,
                'message' => 'The municipality does not belong to the selected region' //traducir
            ], 404);
        }

        DB::beginTransaction();
        try {
            Customer::create($request->all());

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Successful process'
            ], 200);

        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $dni)
    {
        $customer = Customer::where('dni', $dni)->where('status', '!=', 'trash');

        if(!$customer->exists()){
            return response()->json([
                'success' => false,
                'message' => 'Record not found'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $customer->update([
                'status' => 'trash'
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Successful process'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }
}
