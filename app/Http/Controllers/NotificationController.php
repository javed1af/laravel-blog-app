<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            // Admin sees all notifications
            $notifications = Notification::with('users', 'creator')->latest()->paginate(10);
        } else {
            // Normal user sees only their notifications
            $notifications = $user->notifications()->with('creator')->latest()->paginate(10);
        }

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Notification::class);
        $users = User::all();
        return view('notifications.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Notification::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        // 1. Create the notification record once.
        $notification = Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'created_by' => Auth::id() ?? 1,
        ]);

        // 2. Attach all selected users to the notification.
        $notification->users()->attach($request->users);

        // 3. Get the user models and loop through them to send the email.
        $users = User::whereIn('id', $request->users)->get();
        info('users: ', [$users]);
        foreach ($users as $user) {
            $params = [
                'to' => $user->email,
                'subject' => 'Notification from IT dep',
            ];

            Mail::send([], [], function ($message) use ($params) {
                $message->to($params['to'])
                    ->subject($params['subject'])
                    ->html('emails.notification');
            });

            // $user->notify(new UserNotification($request->title, $request->message));
        }

        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        // $this->authorize('view', $notification);
        // $notification->load('users', 'creator');
        return view('notifications.show', compact('notification'));
    }

    public function toggleReadStatus(Notification $notification, User $user)
    {
        // $this->authorize('update', $notification);
        $pivot = $notification->users()->where('user_id', $user->id)->first()->pivot;
        $pivot->is_read = !$pivot->is_read;
        $pivot->save();

        return back()->with('success', 'Status updated successfully!');
    }

    public function markAsRead(Notification $notification)
    {
        $user = Auth::user();
        $user->notifications()->updateExistingPivot($notification->id, ['is_read' => true]);

        return back()->with('success', 'Notification marked as read.');
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
