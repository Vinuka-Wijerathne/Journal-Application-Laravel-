<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('journal_entries', function (Blueprint $table) {
        $table->boolean('is_favorite')->default(false); // Add the is_favorite column
    });
}

public function down()
{
    Schema::table('journal_entries', function (Blueprint $table) {
        $table->dropColumn('is_favorite'); // Drop the column if rolling back
    });
}


   
};
