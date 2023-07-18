<?php


use App\Enums\Gender;
use App\Enums\MaritalStatus;
use App\Enums\Nations;
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
            $table->enum('naturalness', array_column(Nations::cases(), 'value'))->default('Nao Informado');
            $table->enum('nationality', array_column(Nations::cases(), 'value'))->default('Nao Informado');
            $table->enum('typeSex', array_column(Gender::cases(), 'value'))->default('Nao Informar');
            $table->enum('maritalStatus', array_column(MaritalStatus::cases(), 'value'))->default('Solteiro(a)');
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
