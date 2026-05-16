<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsDetail; // Include the NewsDetail model
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('details')->orderBy('created_at', 'DESC')->get(); // Eager load details
        return view('frontend.news.index', compact('news'));
    }

    public function Adminindex()
    {
        $news = News::with('details')->get(); // Eager load details
        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'header' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string',
                'details' => 'array',
                'details.*.short_title' => 'required_with:details|string|max:255',
                'details.*.short_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'details.*.short_description' => 'required_with:details|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }

        // Save the main news image in the 'images' directory in public folder
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'images/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imagePath);
        }

        // Save the main news item
        $news = News::create([
            'header' => $validated['header'],
            'image' => $imagePath,
            'description' => $validated['description'],
        ]);

        // Filter and save valid details
        if (isset($validated['details']) && is_array($validated['details'])) {
            foreach ($validated['details'] as $detail) {
                $shortImagePath = null;
                if (isset($detail['short_image']) && $detail['short_image']) {
                    $shortImage = $detail['short_image'];
                    $shortImagePath = 'images/' . uniqid() . '.' . $shortImage->getClientOriginalExtension();
                    $shortImage->move(public_path('images'), $shortImagePath);
                }

                NewsDetail::create([
                    'news_id' => $news->id,
                    'short_title' => $detail['short_title'],
                    'short_image' => $shortImagePath,
                    'short_description' => $detail['short_description'],
                ]);
            }
        }

        return redirect()->route('admin.news')->with('message', 'News has been uploaded successfully!');
    }



    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->details()->delete();
        $news->delete();

        return redirect()->route('admin.news')->with('error', 'News has been deleted successfully!');
    }

    public function edit($id)
    {
        $news = News::with('details')->findOrFail($id); // Load details for editing
        return view('admin.news.create', compact('news'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'header' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'details' => 'required|array',
                'details.*.id' => 'nullable|exists:news_details,id',
                'details.*.short_title' => 'required|string|max:255',
                'details.*.short_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'details.*.short_description' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }

        $news = News::findOrFail($id);
        $news->header = $validated['header'];
        $news->description = $validated['description'];

        // Update the main news image
        if ($request->hasFile('image')) {
            if ($news->image) {
                @unlink(public_path($news->image)); // Delete old image
            }
            $image = $request->file('image');
            $news->image = 'images/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $news->image);
        }

        $news->save();

        $detailIds = collect($validated['details'])->pluck('id')->filter();
        $news->details()->whereNotIn('id', $detailIds)->delete();

        foreach ($validated['details'] as $detail) {
            $newsDetail = $news->details()->find($detail['id'] ?? null);

            if ($newsDetail) {
                $newsDetail->short_title = $detail['short_title'];
                $newsDetail->short_description = $detail['short_description'];

                if (isset($detail['short_image']) && $detail['short_image']) {
                    if ($newsDetail->short_image) {
                        @unlink(public_path($newsDetail->short_image)); // Delete old detail image
                    }
                    $shortImage = $detail['short_image'];
                    $newsDetail->short_image = 'images/' . uniqid() . '.' . $shortImage->getClientOriginalExtension();
                    $shortImage->move(public_path('images'), $newsDetail->short_image);
                }

                $newsDetail->save();
            } else {
                $shortImagePath = null;
                if (isset($detail['short_image']) && $detail['short_image']) {
                    $shortImage = $detail['short_image'];
                    $shortImagePath = 'images/' . uniqid() . '.' . $shortImage->getClientOriginalExtension();
                    $shortImage->move(public_path('images'), $shortImagePath);
                }

                NewsDetail::create([
                    'news_id' => $news->id,
                    'short_title' => $detail['short_title'],
                    'short_image' => $shortImagePath,
                    'short_description' => $detail['short_description'],
                ]);
            }
        }

        return redirect()->route('admin.news')->with('message', 'News updated successfully!');
    }



    public function create()
    {
        return view('admin.news.create');
    }

    public function newsview($id)
    {
        $article = News::with('details')->findOrFail($id); // Load details for frontend view
        return view('frontend.news.newsview', compact('article'));
    }
}
