<?php

use App\Models\City;
use App\Models\Property;
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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('cash')->default(100);
            $table->unsignedBigInteger('bank')->default(0);
            $table->unsignedInteger('tokens')->default(0);
            $table->dateTime('premium')->nullable();

            $table->foreignIdFor(City::class)->default(1)->constrained();
            $table->foreignIdFor(Property::class)->default(1)->constrained();

            $table->double('energy')->unsigned()->default(0);
            $table->double('nerve')->unsigned()->default(0);
            $table->double('health')->unsigned()->default(0);
            $table->double('power')->unsigned()->default(0);

            $table->unsignedInteger('max_energy')->default(100);
            $table->unsignedInteger('max_nerve')->default(10);
            $table->unsignedInteger('max_health')->default(100);

            // Force regeneration on the first page-load
            $table->dateTime('regenerated_at')->default('2000-01-01 00:00:00');

            // Crime/task experience
            $table->double('experience')->unsigned()->default(0);

            // Combat level is calculated from the stats
            $table->double('strength')->unsigned()->default(0);
            $table->double('agility')->unsigned()->default(0);
            $table->double('defense')->unsigned()->default(0);
            $table->double('intelligence')->unsigned()->default(0);
            $table->double('endurance')->unsigned()->default(0);

            $table->dateTime('hospital')->default('2000-01-01 00:00:00');
            $table->dateTime('jail')->default('2000-01-01 00:00:00');
            $table->string('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
