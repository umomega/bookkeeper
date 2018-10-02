<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');

            $table->string('first_name', 64);
            $table->string('last_name', 64)->nullable();
            $table->string('company', 128)->nullable();
            $table->string('job_title', 64)->nullable();

            $table->string('email')->nullable();
            $table->string('tel', 64)->nullable();
            $table->string('tel_mobile', 64)->nullable();
            $table->string('fax', 64)->nullable();

            $table->string('nationality', 32)->nullable();
            $table->string('national_id', 32)->nullable();

            $table->string('address')->nullable();
            $table->string('city', 64)->nullable();
            $table->string('country', 64)->nullable();
            $table->string('postal_code', 16)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });

        Schema::create('people_list_person', function (Blueprint $table)
        {
            $table->integer('people_list_id')->unsigned();
            $table->integer('person_id')->unsigned();

            $table->foreign('people_list_id')
                ->references('id')
                ->on('people_lists')
                ->onDelete('cascade');

            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade');

            $table->primary(['people_list_id', 'person_id']);
        });

        Schema::create('client_person', function (Blueprint $table)
        {
            $table->integer('client_id')->unsigned();
            $table->integer('person_id')->unsigned();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade');

            $table->primary(['client_id', 'person_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_list_person');
        Schema::dropIfExists('client_person');
        Schema::dropIfExists('people');
    }
}
