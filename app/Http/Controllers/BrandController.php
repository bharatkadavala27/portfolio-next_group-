<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        // Fetch brand data from the database
        $brands = Brand::all();

        // Return the view with the brand data
        return view('brand.index', compact('brands'));
    }
}
