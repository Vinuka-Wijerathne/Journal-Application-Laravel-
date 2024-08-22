<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('journal_entries', function (Blueprint $table) {
        $table->string('image_path')->nullable(); // Add a nullable column for the image path
    });
}

public function down()
{
    Schema::table('journal_entries', function (Blueprint $table) {
        $table->dropColumn('image_path'); // Remove the column if rolling back
    });
}

};
