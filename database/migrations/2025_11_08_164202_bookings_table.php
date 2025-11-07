<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lab_id')->constrained('labs')->onDelete('cascade');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->enum('waktu', [
                '07:30-09:10',
                '09:15-10:55',
                '11:00-12:40',
                '13:55-15:30',
                '15:55-17:30'
            ]);
            $table->date('tanggal');
            $table->text('keperluan');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->unique(['lab_id', 'tanggal', 'waktu']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};