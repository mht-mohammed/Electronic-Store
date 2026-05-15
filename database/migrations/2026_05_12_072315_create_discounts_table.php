<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('discounts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->enum('type', ['percent', 'fixed']);
        $table->decimal('value', 10, 2);
        $table->timestamp('starts_at')->nullable();
        $table->timestamp('ends_at')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();

        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('discounts');
}
};
