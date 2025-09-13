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


    // Store booking form submission
    public function store(Request $request)
    {
        $request->validate([
            'package_id'     => 'required|exists:packages,id',
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:50',
            'booking_date'   => 'required|date',
            'adults'         => 'required|integer|min:1',
            'children'       => 'nullable|integer|min:0',
        ]);

        $package = Packages::findOrFail($request->package_id);

        // calculate total
        $perHead = (float) $package->per_head_price;
        $adultCount = (int) $request->adults;
        $childCount = (int) $request->children;

        $total = $perHead * ($adultCount + ($childCount * 0.5));

        $booking = Bookings::create([
            'package_id'     => $package->id,
            'user_id'        => auth()->id(),
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'booking_date'   => $request->booking_date,
            'adults'         => $adultCount,
            'children'       => $childCount,
            'total_price'    => $total,
            'note'           => $request->note,
            'status'         => 'pending',
        ]);

        return redirect()->back()->with('success', 'Booking submitted successfully! We will contact you soon.');
    }

    public function adminIndex()
    {
        $bookings = Bookings::with('package')->orderBy('created_at','desc')->get();
        return view('AdminPanel.Bookings.index', compact('bookings'));
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
