<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProductCreatedNotification extends Notification
{
    use Queueable;

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = route('products.index');
        
        return (new MailMessage)
            ->subject('New Product Created')
            ->line('A new product has been created: ' . $this->product->title)
            ->line('Quantity: ' . $this->product->quantity)
            ->action('View Product', $url)
            ->line('Thank you for using our application!');
    }
}