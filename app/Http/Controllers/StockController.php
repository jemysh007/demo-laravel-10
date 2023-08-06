<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;

class StockController extends BaseController
{
    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            '*.item_code' => 'required|string|unique:stocks,item_code',
            '*.item_name' => 'required|string',
            '*.quantity' => 'required|integer|min:1',
            '*.location' => 'required|string',
            '*.store_name' => 'required|string',
            '*.in_stock_date' => 'required|date',
        ], [
            '*.item_code.unique' => 'The item code ":input" is already taken.',
        ]);


        if ($validator->fails()) {
            $message = $validator->errors()->first();

            return $this->sendError($message);
        }

        $data = $request->all();
        Stock::insert($data);

        return $this->sendResponse([], 'Stock Data added successfully');
    }

    public function list(Request $request)
    {

        $page = $request->input('page', 1);
        $size = $request->input('size', 10);
        $sortParams = $request->input('sort');

        $query = Stock::query();

        // Apply sorting if sorting parameters are provided
        if ($sortParams && is_array($sortParams) && count($sortParams) > 0) {
            $sortField = $sortParams[0]['field'];
            $sortDirection = $sortParams[0]['dir'];
            $query->orderBy($sortField, $sortDirection);
        }

        $stocks = $query->paginate($size, ['*'], 'page', $page);

        $responseData = [
            'data' => $stocks->items(), // Use the items from the pagination result
            'max_page' => ceil($stocks->total() / $size),

        ];

        return response()->json($responseData);
    }


    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stock_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->sendError($message);
        }

        $stockId = $request->input('stock_id');

        try {
            $stock = Stock::find($stockId)->first();
            $stock->delete();
            return $this->sendResponse([], 'Stock Data deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete stock data');
        }
    }
}
