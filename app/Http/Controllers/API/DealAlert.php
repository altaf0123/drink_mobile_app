<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealAlert extends Controller
{
    public function deals() {
        return response()->json("ok");
    }

}
