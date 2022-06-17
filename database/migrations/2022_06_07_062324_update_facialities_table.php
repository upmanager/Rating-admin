<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFacialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {
            //
            $table->text('offices')->nullable()->after('managerid')->default()->comment('');
            $table->string('record_number')->after('qty');
            $table->string('license_number')->after('record_number');
            $table->text('content')->after('license_number')->nullable()->comment('Facilities page content');
            $table->string('pdf')->after('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facilities', function (Blueprint $table) {
            //
        });
    }
}
