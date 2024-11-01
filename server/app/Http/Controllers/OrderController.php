<?php

namespace App\Http\Controllers;

use App\Services\BookingServices;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected $bookingServices;

    public function __construct(BookingServices $bookingServices)
    {
        $this->bookingServices = $bookingServices;
    }

    public function showForm()
    {
        return view('home'); // Рендерит Blade-шаблон 'home.blade.php'
    }

    public function book(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer',
            'event_date' => 'required|date',
            'ticket_adult_price' => 'required|numeric',
            'ticket_adult_quantity' => 'required|integer',
            'ticket_kid_price' => 'required|numeric',
            'ticket_kid_quantity' => 'required|integer',
        ]);


        // Mock API booking process
        $result = $this->bookingServices->bookOrder($validated);
        return $result;
    }

    public function approve(Request $request)
    {

        $validated = $request->validate([
            'barcode' => 'required|string',
        ]);


        // Mock API approve process
        $result = $this->bookingServices->approve($validated);
        return $result;
    }
}
