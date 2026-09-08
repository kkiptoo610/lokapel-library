<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $notifications = $request
            ->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }


    /**
     * Mark all unread notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request
            ->user()
            ->unreadNotifications
            ->markAsRead();


        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'All notifications have been marked as read.'
            );
    }


    /**
     * Mark one notification as read.
     */
    public function markAsRead(
        Request $request,
        string $notificationId
    )
    {
        /*
        |--------------------------------------------------------------------------
        | FIND NOTIFICATION
        |--------------------------------------------------------------------------
        |
        | Only search notifications belonging to the currently logged-in user.
        | This prevents users from accessing other users' notifications.
        |
        */

        $notification = $request
            ->user()
            ->notifications()
            ->where(
                'id',
                $notificationId
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!$notification) {

            return redirect()
                ->route('notifications.index')
                ->with(
                    'error',
                    'Notification not found or you do not have permission to access it.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MARK AS READ
        |--------------------------------------------------------------------------
        */

        if (is_null($notification->read_at)) {

            $notification->markAsRead();

        }


        /*
        |--------------------------------------------------------------------------
        | GET NOTIFICATION URL
        |--------------------------------------------------------------------------
        */

        $url = $notification->data['url'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO URL
        |--------------------------------------------------------------------------
        */

        if (!empty($url)) {

            return redirect($url)
                ->with(
                    'success',
                    'Notification marked as read.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT BACK TO NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'Notification marked as read.'
            );
    }


    /**
     * Delete one notification.
     */
    public function destroy(
        Request $request,
        string $notificationId
    )
    {
        /*
        |--------------------------------------------------------------------------
        | FIND NOTIFICATION
        |--------------------------------------------------------------------------
        */

        $notification = $request
            ->user()
            ->notifications()
            ->where(
                'id',
                $notificationId
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!$notification) {

            return redirect()
                ->route('notifications.index')
                ->with(
                    'error',
                    'Notification not found or you do not have permission to delete it.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        $notification->delete();


        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'Notification deleted successfully.'
            );
    }
}