<?php

use App\Models\{CategoryType, Department};
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
            $table->foreignIdFor(CategoryType::class)->nullable(false);
            $table->foreignIdFor(Department::class)->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('image')->nullable(false);
            $table->json('colors')->nullable(false);
            $table->json('sizes')->nullable(false);
            $table->longText('description')->nullable(false);
            $table->string('material')->nullable(false);
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
