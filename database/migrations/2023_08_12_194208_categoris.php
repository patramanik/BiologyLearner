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
        Schema::create('catagoris',function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('mata_title');
            $table->string('image');
            $table->text('c_keywords');
            $table->text('meta_description');
            $table->tinyInteger('status')->default('0');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::drop('catagoris');
    }
};
