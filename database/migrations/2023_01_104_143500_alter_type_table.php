<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type', function (Blueprint $table) {
					$table->enum('input_type', ['text', 'tel', 'number', 'email', 'url'])
								->after('title')
								->default('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type', function (Blueprint $table) {
					$table->dropColumn(['input_type']);
        });
    }
}
