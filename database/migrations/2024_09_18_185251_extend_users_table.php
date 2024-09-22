<?php

use App\Models\City;
use App\Models\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('cash')->after('remember_token');
            $table->unsignedBigInteger('bank')->after('cash');
            $table->unsignedInteger('tokens')->after('bank');
            $table->dateTime('premium')->nullable()->after('tokens');

            $table->double('energy')->after('premium');
            $table->double('nerve')->after('energy');
            $table->double('health')->after('nerve');
            $table->double('power')->after('health');

            $table->unsignedSmallInteger('max_energy')->after('power');
            $table->unsignedSmallInteger('max_nerve')->after('max_energy');
            $table->unsignedSmallInteger('max_health')->after('max_nerve');

            $table->dateTime('regenerated_at')->after('max_health');

            $table->double('strength')->after('regenerated_at');
            $table->double('agility')->after('strength');
            $table->double('defense')->after('agility');
            $table->double('intelligence')->after('defense');
            $table->double('endurance')->after('intelligence');

            $table->foreignIdFor(City::class)->after('intelligence')->constrained()->restrictOnDelete();
            $table->foreignIdFor(Property::class)->after('city_id')->constrained()->restrictOnDelete();

            $table->dateTime('jail')->after('property_id');
            $table->dateTime('hospital')->after('jail');
            $table->string('reason')->after('hospital')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumns(['premium', 'tokens', 'bank', 'cash']);
        });
    }
};
