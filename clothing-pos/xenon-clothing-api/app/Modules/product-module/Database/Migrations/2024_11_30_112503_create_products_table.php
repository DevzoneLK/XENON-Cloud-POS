<?php

namespace App\Modules\Product\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Create the products table
        Schema::create('products', function (Blueprint $table) {
            // Auto-incrementing ID
            $table->id();

            // Name of the product (required, max 255 characters)
            $table->string('name', 255);

            // Description of the product (optional)
            $table->text('description')->nullable();

            // Selling price (required, numeric)
            $table->decimal('selling_price', 10, 2);

            // Special note for the product (optional)
            $table->string('special_note')->nullable();

            // Whether the product is enabled (required, boolean)
            $table->boolean('is_enabled')->default(true);

            // Unique product code (required)
            $table->string('code', 255)->unique();

            // Timestamps for created and updated times
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
