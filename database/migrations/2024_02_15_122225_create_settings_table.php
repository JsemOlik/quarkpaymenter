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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 191); // or 255
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->boolean('encrypted')->default(false);
            $table->nullableMorphs('settingable');
            // $table->unique(['key', 'settingable_id', 'settingable_type']);
            $table->unique([DB::raw('`key`(191)'), 'settingable_id', 'settingable_type'], 'settings_key_settingable_id_settingable_type_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
