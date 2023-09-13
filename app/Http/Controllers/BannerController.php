<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannersListResource;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index()
    {
        try {

            $records = Banner::orderBy('id', 'DESC')->get();

            return apiResponse(
                true,
                '',
                200,
                BannersListResource::collection($records),
            );
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
