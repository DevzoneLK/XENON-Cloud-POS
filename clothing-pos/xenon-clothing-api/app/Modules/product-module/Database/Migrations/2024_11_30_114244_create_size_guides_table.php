<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('size_guides', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Category of the size guide (e.g., t-shirt, pants)
            $table->string('size'); // Size (e.g., S, M, L, XL)
            $table->string('value'); // Value for the size (e.g., measurements)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('size_guides');
    }
};