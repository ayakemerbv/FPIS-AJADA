<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = auth()->user();
        Log::info('User fetching notifications', [
            'user_id' => $user->id,
            'user_email' => $user->email
        ]);

        $notifications = $user->notifications;
        Log::info('Notifications found', [
            'count' => $notifications->count(),
            'notifications' => $notifications->toArray()
        ]);

        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        Log::info('Marking notification as read', ['notification_id' => $id]);

        try {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            Log::info('Notification marked as read successfully');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error marking notification as read', [
                'error' => $e->getMessage(),
                'notification_id' => $id
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
