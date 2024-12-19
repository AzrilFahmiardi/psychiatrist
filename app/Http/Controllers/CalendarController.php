<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;

class CalendarController extends Controller
{
    public function index()
    {
        $calendarService = new GoogleCalendarService(auth()->user());
        $events = $calendarService->listEvents();
        
        return view('calendar.index', compact('events'));
    }

    public function show()
    {
        $user = auth()->user();
        return view('calendar.show');
    }
}
