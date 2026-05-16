<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Slider;
use App\Models\Category;
use App\Models\TwoImageSlider;
use App\Models\SecondSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SliderFormRequest;

class TwoImageSliderController extends Controller
{
    public function index()
    {
        $twoImageSliders = TwoImageSlider::all();
        return view('admin.twoimagesliders.index', compact('twoImageSliders'));
    }

    public function view()
    {
        $sliders = Slider::all();
        $brand = Brand::all();
        $category = Category::with('parentCategory')->whereNull('parent_id')->get();
        $categories = Category::with('parentCategory')->whereNull('parent_id')->get();
        $secondSlider = SecondSlider::all();
        $twoImageSliders = TwoImageSlider::all();

        return view('index', compact('sliders', 'brand', 'category', 'secondSlider', 'twoImageSliders', 'categories'));
    }

    public function create()
    {
        return view('admin.twoimagesliders.create');
    }

    public function store(SliderFormRequest $request)
    {
        $validatedData = $request->validated();
        $imageFile = request()->hasFile('image') ? request()->file('image') : null;
        if ($imageFile) {
            $ext = $imageFile->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $imageFile->move('uploads/two-image-slider/', $filename);
            $validatedData['image'] = $filename;
        }
        $validatedData['status'] = isset($validatedData['status']) && $validatedData['status'] ? '1' : '0';
        TwoImageSlider::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'] ?? null,
            'status' => $validatedData['status'],
        ]);
        return redirect('admin/all-slider')->with('message', 'Two Image Slider added Successfully');
    }

    public function edit(TwoImageSlider $twoImageSlider)
    {
        return view('admin.twoimagesliders.edit', compact('twoImageSlider'));
    }

    public function update(SliderFormRequest $request, TwoImageSlider $twoImageSlider)
    {
        $validatedData = $request->validated();
        $imageFile = request()->hasFile('image') ? request()->file('image') : null;
        if ($imageFile) {
            $destination = 'uploads/two-image-slider/' . $twoImageSlider->image;
            if ($twoImageSlider->image && File::exists($destination)) {
                File::delete($destination);
            }
            $ext = $imageFile->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $imageFile->move('uploads/two-image-slider/', $filename);
            $validatedData['image'] = $filename;
        }
        $validatedData['status'] = isset($validatedData['status']) && $validatedData['status'] ? '1' : '0';
        TwoImageSlider::where('id', $twoImageSlider->id)->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'] ?? $twoImageSlider->image,
            'status' => $validatedData['status'],
        ]);
        return redirect('admin/all-slider')->with('message', 'Two Image Slider updated Successfully');
    }

    public function destroy(TwoImageSlider $twoImageSlider)
    {
        if ($twoImageSlider) {
            $destination = 'uploads/two-image-slider/' . $twoImageSlider->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $twoImageSlider->delete();
            return redirect('admin/all-slider')->with('message', 'Two Image Slider deleted Successfully');
        }
        return redirect()->route('admin.twoimagesliders.index')->with('error', 'Something went wrong');
    }
}
