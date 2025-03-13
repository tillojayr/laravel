<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Models\User;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendProductCreatedNotification
{
    public function handle(ProductCreated $event)
    {
        // Get all admin users
        $admins = User::where('is_admin', true)->get();
        
        // Send notification to all admins
        Notification::send($admins, new ProductCreatedNotification($event->product));
    }
}