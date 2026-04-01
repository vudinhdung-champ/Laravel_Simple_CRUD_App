<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;


class Promise extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'promiser_name',
        'promise_content',
        'date_made',
        'deadline',
        'status',
        'importance_level'

    ];

    protected $cast = [
        'date_made' => 'date',
        'deadline' => 'date',
        'importance_level' => 'integer'

    ];

    public function user() {
        return $this->belongsTo(User::class);

    }
    

}
