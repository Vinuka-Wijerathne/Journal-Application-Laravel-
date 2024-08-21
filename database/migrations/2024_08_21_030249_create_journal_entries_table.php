<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->timestamp('date')->useCurrent(); // Ensure this is a timestamp
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('journal_entries');
    }
}
