<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use Illuminate\Http\Request;

class DestinationsController extends Controller
{

    // Show list and form
    public function index(Request $request)
    {
        $destinations = destinations::all();
        $destination = session('editDestination'); // retrieve the destination for editing

        return view('AdminPanel.Destinations.index', compact('destinations', 'destination'));
    }

    // Store new destination
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        destinations::create($request->all());

        return redirect()->route('destinations.index')->with('success', 'Destination added successfully!');
    }

    // Load destination into form for editing
    public function edit(destinations $destination)
    {
        return redirect()->route('destinations.index')->with('editDestination', $destination);
    }

    // Update destination
    public function update(Request $request, destinations $destination)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $destination->update($request->all());

        return redirect()->route('destinations.index')->with('success', 'Destination updated successfully!');
    }

    // Delete destination
    public function destroy(destinations $destination)
    {
        $destination->delete();
        return redirect()->back()->with('success', 'Destination deleted successfully!');
    }
























}
