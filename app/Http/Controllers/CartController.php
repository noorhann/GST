<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCartRequest;
use App\Http\Resources\CartsSingleResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function create(CreateCartRequest $request)
    {
        try {

            $data = Cart::create($request->all());
        
            return apiResponse(
                true,
                'Added To Cart Successfully',
                201,
            );
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
