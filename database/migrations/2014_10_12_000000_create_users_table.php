<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->unsignedBigInteger('placement_id')->nullable();
            $table->unsignedTinyInteger('direction')->nullable();
            $table->string('level', 50)->nullable();
            $table->string('name', 50);
            $table->integer('referer_id')->nullable()->unique();
            $table->string('username', 25)->unique();
            $table->string('email');
            $table->string('phone', 30);
            $table->string('password');
            $table->decimal('register_package', 8, 2)->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('status')->default(true);
            $table->string('avatar')->default('default.png');
            $table->date('joining_date');
            $table->string('joining_month', 15);
            $table->year('joining_year');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
