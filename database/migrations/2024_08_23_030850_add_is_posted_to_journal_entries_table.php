<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->boolean('is_posted')->default(false); // Add the is_posted column
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('journal_entries', function (Blueprint $table) {
        $table->dropColumn('is_posted'); // Remove the is_posted column
    });
}

};
