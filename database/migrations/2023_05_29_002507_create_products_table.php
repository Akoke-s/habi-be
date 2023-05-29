<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('image')->nullable(false);
            $table->longText('description')->nullable(false);
            $table->foreignIdFor(Category::class)->nullable(false);
            $table->string('slug')->nullable(false);
            $table->string('status')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
