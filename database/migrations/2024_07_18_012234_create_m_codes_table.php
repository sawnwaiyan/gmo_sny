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
        Schema::create('m_codes', function (Blueprint $table) {
            $table->id();
            $table->string('pa_cd', 6);
            $table->tinyInteger('ch_cd');
            $table->string('pa_name');
            $table->string('ch_name');
            $table->tinyInteger('sort_order')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('created_by', 20)->default("");
            $table->string('updated_by', 20)->default("");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_codes');
    }
};
