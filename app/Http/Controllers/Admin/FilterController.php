<?php

namespace App\Http\Controllers\Admin;

use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Http\Request;
use App\Models\DocumentsSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    // Show all documents with filters
    public function index()
    {
        $filters = Filter::with('options')->orderBy('sequence')->get();
        return view('admin.filter.index', compact('filters'));
    }

    // Show create filter form
    public function create()
    {
        return view('admin.filter.create');
    }

    // Store filter + options
    public function store(Request $request)
    {
        $request->validate([
            'filter_name' => 'required|string|max:255',
            'type' => 'required|in:document,product,both',
            'options_new' => 'nullable|array',
            'options_new.*' => 'nullable|string|max:255',
            'options_existing' => 'nullable|array',
            'options_existing.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Save filter
            $filter = Filter::create([
                'name' => $request->filter_name,
                'type' => $request->type,
                'download_sequence' => (Filter::max('download_sequence') ?? 0) + 1,
            ]);

            // Save new options
            $newOptions = $request->input('options_new', []);
            foreach ($newOptions as $option) {
                if (!empty($option)) {
                    FilterOption::create([
                        'filter_id' => $filter->id,
                        'name' => $option,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.filters.index')
                ->with('success', 'Filter created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Show edit form (accept id because routes use {id})
    public function edit($id)
    {
        $filter = Filter::findOrFail($id);
        return view('admin.filter.create', compact('filter'));
    }

    // Update filter + options
    public function update(Request $request, $id)
    {
        $filter = Filter::findOrFail($id);
        $request->validate([
            'filter_name' => 'required|string|max:255',
            'type' => 'required|in:document,product,both',
            'options_new' => 'nullable|array',
            'options_new.*' => 'nullable|string|max:255',
            'options_existing' => 'nullable|array',
            'options_existing.*' => 'nullable|string|max:255',
            'options_delete' => 'nullable|array',
            'options_delete.*' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            // Update filter name
            $filter->update([
                'name' => $request->filter_name,
                'type' => $request->type,
                'download_sequence' => $request->download_sequence ?? $filter->download_sequence,
            ]);

            // Delete removed existing options
            $toDelete = $request->input('options_delete', []);
            if (!empty($toDelete)) {
                FilterOption::whereIn('id', $toDelete)->where('filter_id', $filter->id)->delete();
            }

            // Update existing options (by id => value)
            $existing = $request->input('options_existing', []);
            foreach ($existing as $id => $value) {
                $opt = FilterOption::where('id', $id)->where('filter_id', $filter->id)->first();
                if ($opt) {
                    $opt->update(['name' => $value]);
                }
            }

            // Add new options
            $newOptions = $request->input('options_new', []);
            foreach ($newOptions as $option) {
                if (!empty($option)) {
                    FilterOption::create([
                        'filter_id' => $filter->id,
                        'name' => $option,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.filters.index')->with('success', 'Filter updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Destroy filter and its options
    public function destroy($id)
    {
        $filter = Filter::findOrFail($id);

        // Prevent deleting system filters
        if ($filter->key) {
            return back()->withErrors(['error' => 'System filters cannot be deleted.']);
        }

        DB::beginTransaction();
        try {
            // Delete related options first
            FilterOption::where('filter_id', $filter->id)->delete();
            $filter->delete();
            DB::commit();
            return redirect()->route('admin.filters.index')->with('success', 'Filter deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateSequence(Request $request)
    {
        $sequences = $request->input('sequences', []);
        $downloadSequences = $request->input('download_sequences', []);

        DB::beginTransaction();
        try {
            foreach ($sequences as $id => $sequence) {
                Filter::where('id', $id)->update(['sequence' => $sequence]);
            }
            foreach ($downloadSequences as $id => $sequence) {
                Filter::where('id', $id)->update(['download_sequence' => $sequence]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Filter sequences updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update sequence: ' . $e->getMessage());
        }
    }
}
