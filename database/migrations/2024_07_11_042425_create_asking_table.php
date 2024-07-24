<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('askings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('questionnaire')->default(new Expression('(JSON_ARRAY())'));
            $table->text('header_text')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('logo')->nullable();
            $table->integer('template_id')->default(0);
            $table->string('bg_color')->default('#ffffff');
            $table->string('text_color')->default('#000000');
            $table->integer('count_view_flg')->default(0);
            $table->integer('coupon_id')->nullable();
            $table->integer('open_flg')->default(0);
            $table->text('tag')->nullable();
            $table->text('biko')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asking');
    }
};
