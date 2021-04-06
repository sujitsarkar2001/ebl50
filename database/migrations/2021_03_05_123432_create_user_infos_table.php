<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('country', 50)->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('post_code', 15)->nullable();
            $table->string('gender', 7)->nullable();
            $table->date('d_o_b')->nullable();
            $table->string('nid', 25)->nullable();
            $table->string('nominee', 25)->nullable();
            $table->string('nominee_relation', 25)->nullable();
            $table->string('profession')->nullable();
            $table->string('education')->nullable();
            $table->string('facebook')->nullable();
            $table->string('bank_name', 50)->nullable();
            $table->string('bank_account_name', 50)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->string('branch_name', 50)->nullable();
            $table->string('bkash', 15)->nullable();
            $table->string('nagad', 15)->nullable();
            $table->string('rocket', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
}
