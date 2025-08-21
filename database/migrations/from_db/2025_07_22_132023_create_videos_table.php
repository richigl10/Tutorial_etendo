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
        Schema::connection('erp_tutorial')->create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('path');
            $table->string('pdf_path')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('completed')->default(false);
            $table->unsignedBigInteger('module_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('erp_tutorial')->dropIfExists('videos');
    }
};
