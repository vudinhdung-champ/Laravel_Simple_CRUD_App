<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\User;


class Notebook extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category'
    ];

    protected $cast = [
        
    ];

    public function user() {
        return $this->belongsTo(User::class);

    }
}
