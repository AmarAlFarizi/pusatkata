<?php

use App\Enums\IsbnStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('isbn_status')->default(IsbnStatus::Pengajuan->value);
            $table->string('isbn_number')->nullable();
            $table->string('cover')->nullable();
            $table->text('synopsis')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedInteger('pages')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->string('marketplace_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index('isbn_status');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
