<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReminderSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('reminder_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reminder_id');
            $table->string('repeat_value')->nullable();
            $table->timestamps();

            $table->foreign('reminder_id')->references('id')->on('reminders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminder_settings');
    }
}
