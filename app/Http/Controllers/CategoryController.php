<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriesListResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $records = Category::orderBy('id', 'DESC')->get();

            return apiResponse(
                true,
                '',
                200,
                CategoriesListResource::collection($records),
            );
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
