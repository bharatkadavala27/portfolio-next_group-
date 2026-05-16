<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AboutSettings;
use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
     // public function about(){
    //     $setting = Setting::first();
    //     return view('admin.setting.about-us', compact('setting'));
    // }

    // Show the settings form
    public function about()
    {
        $setting = AboutSettings::first(); // Assuming you have only one settings record
        return view('admin.settings.about-us', compact('setting'));
    }

    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'about_us_title_1' => 'required|string|max:255',
        'about_us_description_1' => 'nullable|string',
        'about_us_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'about_us_title_2' => 'required|string|max:255',
        'about_us_description_2' => 'nullable|string',
        'about_us_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'about_us_title_3' => 'required|string|max:255',
        'about_us_description_3' => 'nullable|string',
        'about_us_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'mission_title' => 'required|string|max:255',
        'mission_description' => 'nullable|string',
        'mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'vision_title' => 'required|string|max:255',
        'vision_description' => 'nullable|string',
        'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'goals_title' => 'required|string|max:255',
        'goals_description' => 'nullable|string',
        'goals_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Retrieve the first settings record or create a new one if it doesn't exist
    $setting = AboutSettings::first() ?? new AboutSettings();

    // Handle file uploads and store paths
    $this->handleImageUpload($request, 'about_us_image_1', $setting, 'about_us_image_1', 'uploads/about_us');
    $this->handleImageUpload($request, 'about_us_image_2', $setting, 'about_us_image_2', 'uploads/about_us');
    $this->handleImageUpload($request, 'about_us_image_3', $setting, 'about_us_image_3', 'uploads/about_us');
    $this->handleImageUpload($request, 'mission_image', $setting, 'mission_image', 'uploads/mission');
    $this->handleImageUpload($request, 'vision_image', $setting, 'vision_image', 'uploads/vision');
    $this->handleImageUpload($request, 'goals_image', $setting, 'goals_image', 'uploads/goals');

    // Update the settings fields
    $setting->about_us_title_1 = $request->about_us_title_1;
    $setting->about_us_description_1 = $request->about_us_description_1;
    $setting->about_us_title_2 = $request->about_us_title_2;
    $setting->about_us_description_2 = $request->about_us_description_2;
    $setting->about_us_title_3 = $request->about_us_title_3;
    $setting->about_us_description_3 = $request->about_us_description_3;
    $setting->mission_title = $request->mission_title;
    $setting->mission_description = $request->mission_description;
    $setting->vision_title = $request->vision_title;
    $setting->vision_description = $request->vision_description;
    $setting->goals_title = $request->goals_title;
    $setting->goals_description = $request->goals_description;

    // Save the settings record
    $setting->save();

    return redirect()->back()->with('success', 'Settings updated successfully.');
}

private function handleImageUpload(Request $request, $inputName, AboutSettings $setting, $settingField, $uploadPath)
{
    if ($request->hasFile($inputName)) {
        // Delete old image if exists
        if ($setting->$settingField) {
            $oldImagePath = public_path($setting->$settingField);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete old image
            }
        }

        // Handle the new image upload
        $file = $request->file($inputName);
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/aboutus'), $filename);
        $setting->$settingField = 'uploads/aboutus/' . $filename; // Store the new image path
    }
}
}
