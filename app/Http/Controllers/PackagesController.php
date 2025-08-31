<?php

namespace App\Http\Controllers;
use App\Models\Packages;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
   public function index(Request $request)
{
    $packages = Packages::latest()->get();
    $editPackage = null;

    if ($request->has('edit')) {
        $editPackage = Packages::find($request->edit);
    }

    return view('AdminPanel.Package.Index', compact('packages','editPackage'));
}

    // Show create form
    public function create()
    {
        return view('AdminPanel.Package.Index'); // no $package means create
    }

    // Store new package
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'days' => 'required|integer|min:1',
            'nights' => 'required|integer|min:1',
            'benefit_type' => 'required|in:fixed,percent',
            'benefit_value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $package = Packages::create($data);

        return redirect()->route('packages.index')->with('success', 'Package created successfully!');
    }

    // Show edit form
    public function edit(Packages $package)
    {
        return view('AdminPanel.Package.Index', compact('package')); // edit mode
    }

    // Update package
    public function update(Request $request, Packages $package)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'days' => 'required|integer|min:1',
            'nights' => 'required|integer|min:1',
            'benefit_type' => 'required|in:fixed,percent',
            'benefit_value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $package->update($data);

        return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
    }

    // Delete package
    public function destroy(Packages $package)
    {
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully!');
    }

    // Show single package (optional)
    public function show(Packages $package)
    {
        return view('AdminPanel.Package.Index', compact('package'));
    }
}
