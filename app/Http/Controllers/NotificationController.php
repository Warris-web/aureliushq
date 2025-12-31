<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();
        return view('admin.notification', compact('notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Notification::create($request->only('title', 'body'));
        return GeneralController::sendNotification('', 'success', '', 'Notification added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update($request->only('title', 'body'));
        return GeneralController::sendNotification('', 'success', '', 'Notification updated successfully.');
    }

    public function destroy($id)
    {
        Notification::findOrFail($id)->delete();
        return GeneralController::sendNotification('', 'success', '', 'Notification deleted successfully.');
    }
}
