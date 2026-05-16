<?php
namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Models\MiniSlider;
use App\Models\SecondSlider;
use App\Models\TwoImageSlider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::check() && !Auth::user()->isAdmin()) {
                return redirect()->route('home'); // Redirect non-admin users to home
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Admin dashboard view
        return view('admin.dashboard');
    }

    public function slider(){
        $sliders = Slider::all();
        $secondSlider = SecondSlider::all();
        $minisiders = MiniSlider::all();
        $twoImageSliders = TwoImageSlider::all();

        return view('admin.all-slider.all-slider',compact('sliders', 'minisiders','secondSlider','twoImageSliders'));
    }

    public function create()
    {
        return view('admin.all-slider.all-slider-create');
    }
}
