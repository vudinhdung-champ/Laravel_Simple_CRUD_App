<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;



class Subscription extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'service_name',
        'price',
        'billing_cycle',
        'next_billing_date',
        'status',
        'color_code',
        'notes'
    ];

    protected $cast = [
        'next_billing_date' => 'date',
        'price' => 'integer',
    ];

    public function user() {
        return $this->belongsTo(User::class);

    }

}


