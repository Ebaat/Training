<?php

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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();     
            $table->foreignId('user_id') ->constrained();                // مفتاح أساسي id
            $table->string('name');              // الاسم
            $table->string('email')->unique();   // الإيميل (لازم يكون مميز)
            $table->string('phone')->nullable(); // رقم الموبايل (اختياري)
            $table->date('date_of_birth')->nullable(); // تاريخ الميلاد (اختياري)
            $table->text('bio')->nullable();     // نبذة مختصرة
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
