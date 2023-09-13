<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductsRequest;
use App\Http\Resources\ProductsListResource;
use App\Http\Resources\ProductsSingleResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $records = Product::orderBy('id', 'DESC')->get();

            return apiResponse(
                true,
                '',
                200,
                ProductsListResource::collection($records),
            );
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateProductsRequest $request)
    {
        try {

            $data = Product::create($request->all());
            $image = uploadImage($request->image, 'products');
            $data->image  = $image;
            $data->save();

            return apiResponse(
                true,
                'Created Successfully',
                201,
                new ProductsSingleResource($data)
            );
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $record = Product::find($id);

            if ($record) {
                return apiResponse(
                    true,
                    '',
                    200,
                    new ProductsSingleResource($record)
                );
            } else {
                return apiResponse(
                    true,
                    'Not Found !',
                    400,
                );
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function getByCategory($category)
    {
        try {
            $products = Product::whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })->get();

            if ($products) {
                return apiResponse(
                    true,
                    '',
                    200,
                    ProductsListResource::collection($products),
                );
            } else {
                return apiResponse(
                    true,
                    'Not Found !',
                    400,
                );
            }
        } catch (\Throwable $th) {
            dd($th);
            Log::error($th);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
