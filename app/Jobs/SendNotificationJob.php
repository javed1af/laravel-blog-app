<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $message;
    protected $userIds;
    protected $createdBy;

    /**
     * Create a new job instance.
     *
     * @param string $title
     * @param string $message
     * @param array $userIds
     * @param int $createdBy
     */
    public function __construct(string $title, string $message, array $userIds, int $createdBy)
    {
        $this->title = $title;
        $this->message = $message;
        $this->userIds = $userIds;
        $this->createdBy = $createdBy;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        // 1. Create the notification record once.
        $notification = Notification::create([
            'title' => $this->title,
            'message' => $this->message,
            'created_by' => $this->createdBy,
        ]);

        // 2. Attach all selected users to the notification.
        $notification->users()->attach($this->userIds);

        // 3. Get the user models and loop through them to send the email.
        $users = User::whereIn('id', $this->userIds)->get();
        foreach ($users as $user) {
            // $user->notify(new UserNotification($this->title, $this->message));
        }

        // foreach ($users as $user) {
        //     // $params = [
        //     //     'to' => $user->email,
        //     //     'subject' => 'Notification from IT dep',
        //     // ];

        //     // Mail::send([], [], function ($message) use ($params) {
        //     //     $message->to($params['to'])
        //     //         ->subject($params['subject'])
        //     //         ->html('emails.notification');
        //     // });

        // }
    }
}
