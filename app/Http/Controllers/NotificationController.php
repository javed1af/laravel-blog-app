<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::with('users', 'creator')->latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('notifications.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $notification = Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'created_by' => Auth::id() ?? 1,
        ]);

        $notification->users()->attach($request->users);

        $users = User::whereIn('id', $request->users)->get();
        NotificationFacade::send($users, new UserNotification($request->title, $request->message));

        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
