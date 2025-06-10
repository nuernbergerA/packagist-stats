<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('downloads');
            $table->unsignedInteger('favers');

            $table->string('type')->nullable();
            $table->string('version_string')->nullable();
            $table->char('min_version', 3)->nullable()->index();
            $table->char('max_version', 3)->nullable()->index();
            $table->dateTime('last_released_at')->nullable();

            $table->dateTime('checked_at')->nullable();
            $table->timestamps();
        });
    }
};
