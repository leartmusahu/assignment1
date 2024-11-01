<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToInstructorsTable extends Migration
{
    public function up()
{
    Schema::table('instructors', function (Blueprint $table) {
        if (!Schema::hasColumn('instructors', 'name')) {
            $table->string('name')->nullable();
        }
        if (!Schema::hasColumn('instructors', 'email')) {
            $table->string('email')->unique();
        }
        if (!Schema::hasColumn('instructors', 'password')) {
            $table->string('password');
        }
      
    });
}


    public function down()
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'password']); 
        });
    }
}
