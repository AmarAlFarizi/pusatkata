<?php

use App\Enums\ProductionStage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('production_stage')
                ->default(ProductionStage::Registrasi->value)
                ->after('isbn_number');
            $table->timestamp('stage_updated_at')->nullable()->after('production_stage');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['production_stage', 'stage_updated_at']);
        });
    }
};
