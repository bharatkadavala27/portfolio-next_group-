<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    // public function aboutpage(){
    //     return view('frontend.pages.about-us');
    // }
    // public function contactpage(){
    //     return view('frontend.pages.contact-us');
    // }

    // // public function aboutpage(){
    // //     return view('frontend.pages.about-us');
    // // }

    // public function contactpage(){
    //     return view('frontend..pages.contact-us');
    // }

    public function product()
    {
        $products = Product::all();
        return view('frontend.product.index', compact('product'));
    }
}
