<?php

use App\Models\Idea;
use App\Models\User;
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
         Schema::create('idea_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Idea::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->string('image_path')->nullable();
            $table->json('links')->default('[]');
            $table->json('steps')->default('[]');
            $table->json('changed_fields')->default('[]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_histories');
    }
};
