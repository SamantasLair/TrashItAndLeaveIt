<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kapasitas',
        'deskripsi',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}