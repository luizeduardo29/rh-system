<?php

use App\Enums\TypeSex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('initials')->nullable();
            $table->string('photo')->nullable();
            $table->date('birth')->nullable();
            $table->string('naturalness')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable();
            $table->enum('typeContact', array_column(TypeSex::cases(), 'value'))->default('Men');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {

    }
};
