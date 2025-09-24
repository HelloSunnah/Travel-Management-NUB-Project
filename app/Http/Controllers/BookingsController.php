<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Packages;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function show(Packages $package)
    {
        return view('BookingForm', compact('package'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'package_id'     => 'required|exists:packages,id',
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:50',
            'members'         => 'required|integer|min:1',
            'total_price'    => 'required|numeric|min:0',
            'note'           => 'nullable|string|max:500',
        ]);

        $package = Packages::findOrFail($request->package_id);

        // Ensure total is calculated based on members × per head price
        $perHead = (float) $package->per_head_price;
        $adultCount = (int) $request->members;
        $total = $perHead * $adultCount;

        $booking = Bookings::create([
            'package_id'     => $package->id,
            'user_id'        => auth()->id(), // if booking allowed without login, make user_id nullable in DB
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'members'         => $adultCount,
            'total_price'    => $total,
            'note'           => $request->note,
            'status'         => 'pending',
        ]);

        return redirect()->route('frontend') // replace with your route name
            ->with('success', 'Booking submitted successfully! We will contact you soon.');
    }

    public function adminIndex()
    {
        $bookings = Bookings::with('package')->orderBy('created_at', 'desc')->where('status', 'pending')->get();
        return view('AdminPanel.Bookings.index', compact('bookings'));
    }
    public function adminIndexApproved()
    {
        $bookings = Bookings::with('package')->orderBy('created_at', 'desc')->where('status', 'approved')->get();
        return view('AdminPanel.Bookings.Approved', compact('bookings'));
    }

    public function adminIndexCancelled()
    {
        $bookings = Bookings::with('package')->orderBy('created_at', 'desc')->where('status', 'cancelled')->get();
        return view('AdminPanel.Bookings.Cancel', compact('bookings'));
    }

    // Approve a booking
    public function approve(Bookings $booking)
    {
        $booking->status = 'approved';
        $booking->save();
        return back()->with('success', 'Booking approved!');
    }

    // Cancel a booking
    public function cancel(Bookings $booking)
    {
        $booking->status = 'cancelled';
        $booking->save();
        return back()->with('success', 'Booking cancelled!');
    }
}
