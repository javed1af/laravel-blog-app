<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendNotificationJob;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = Notification::query();

        if (!$user->isAdmin()) {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // All users see all notifications on the index page
        $notifications = $query->with(['creator', 'users', 'authUserPivot'])
            ->latest()
            ->paginate(10);

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

        SendNotificationJob::dispatch(
            $request->title,
            $request->message,
            $request->users,
            Auth::id() ?? 1
        );

        $users = User::whereIn('id', $request->users)->get();

        foreach ($users as $user) {
            $params = [
                'to' => $user->email,
                'subject' => 'Notification from IT dep',
            ];

            $data = [
                'title' => $request->title,
                'message' => $request->message
            ];

            Mail::send([], [], function ($message) use ($params, $data) {
                $html = view('emails.notification', $data)->render();

                $message->to($params['to'])
                    ->subject($params['subject'])
                    ->html($html);
            });
        }

        return redirect()->route('notifications.index')->with('success', 'Notification sending has been queued.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        $this->authorize('view', $notification);
        $notification->load('users', 'creator');
        return view('notifications.show', compact('notification'));
    }

    public function toggleReadStatus(Notification $notification, User $user)
    {
        $this->authorize('update', $notification);
        $pivot = $notification->users()->where('user_id', $user->id)->first()->pivot;
        $pivot->is_read = !$pivot->is_read;
        $pivot->save();

        return back()->with('success', 'Status updated successfully!');
    }

    public function markAsRead(Notification $notification)
    {
        $this->authorize('view', $notification);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->notifications()->updateExistingPivot($notification->id, ['is_read' => true]);

        // Reload the notification with updated pivot data to pass to the view
        $notification->load('users', 'creator');

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        $this->authorize('update', $notification);
        $users = User::all();
        $notification->load('users');

        return view('notifications.edit', compact('notification', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $this->authorize('update', $notification);

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $notification->update([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        $notification->users()->sync($request->users);

        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);
        $notification->users()->detach();
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
    }
}
