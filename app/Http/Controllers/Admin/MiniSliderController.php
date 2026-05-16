<?php

namespace App\Http\Controllers\Admin;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Category;
use App\Models\MiniSlider;
use App\Models\SecondSlider;
use Illuminate\Http\Request;
use App\Models\TwoImageSlider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SliderFormRequest;

class MiniSliderController extends Controller
{
    public function index()
    {
        $minisiders = MiniSlider::all();
        return view('admin.minisiders.index',compact('minisiders'));
    }

    public function view()
    {
        // Retrieve all sliders from the database
        $sliders = Slider::all();
        $brand = Brand::all();
        $category =  Category::with('parentCategory')->whereNull('parent_id')->get();;
        $categories = Category::with('parentCategory')->whereNull('parent_id')->get();
        $secondSlider = SecondSlider::all();
        $minislider = MiniSlider::all();
        $twoImageSliders = TwoImageSlider::all();

        // Pass the sliders data to the view
        return view('index', compact('sliders', 'brand', 'category', 'secondSlider','minislider','categories','twoImageSliders'));

    }






    public function create()
    {
        return view('admin.minisiders.create');
    }

    public function store(SliderFormRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/mini-slider/', $filename);
            $validatedData['image'] = $filename;
        }


        $validatedData['status'] = $request->status == true ? '1':'0';
        MiniSlider::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status'],
        ]);

        return redirect('admin/all-slider')->with('message','Slider added Successfuly');
    }


    public function edit(MiniSlider $minisiders)
    {
        return view('admin.minisiders.edit',compact('minisiders'));
    }
    public function update(SliderFormRequest $request, MiniSlider $minisiders)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $destination = $minisiders->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/mini-slider/', $filename);
            $validatedData['image'] = $filename;
        }


        $validatedData['status'] = $request->status == true ? '1':'0';
        MiniSlider::where('id',$minisiders->id)->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status'],
        ]);

        return redirect('admin/all-slider')->with('message','Slider added Successfuly');
    }

    public function destroy(MiniSlider $minisiders)
    {
        if ($minisiders) {
            $destination = $minisiders->image;

            if (File::exists($destination)) {
                File::delete($destination);
            }

            $minisiders->delete();

            return redirect('admin/all-slider')->with('message','Slider delete Successfuly');
        }

        return redirect()->route('admin.minisiders.index')->with('error', 'Something went wrong');
    }

}
