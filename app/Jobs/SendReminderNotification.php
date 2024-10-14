<?php
namespace App\Jobs;

use App\Models\Alert;
use App\Models\AppUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReminderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reminder;

    /**
     * Create a new job instance.
     *
     * @param Alert $reminder
     * @return void
     */
    public function __construct(Alert $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = AppUsers::find($this->reminder->user_id);
        if ($user && $user->device_token) {
            $title = 'Reminder: ' . $this->reminder->text;
            $message = 'You have a reminder scheduled for ' . $this->reminder->date . ' at ' . $this->reminder->time;

            // Send the notification via Firebase
            $response = sendFirebase(
                [$user->device_token], // Device token
                $title,                // Notification title
                $message               // Notification message
            );

            // Log the response
            if ($response) {
                Log::info('Reminder notification sent successfully to user ID: ' . $user->id);
            } else {
                Log::error('Failed to send reminder notification to user ID: ' . $user->id);
            }
        } else {
            Log::warning('No valid device token found for user ID: ' . $this->reminder->user_id);
        }
    }
}
