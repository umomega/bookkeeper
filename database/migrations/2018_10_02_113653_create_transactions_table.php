<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('type', [
                'income',
                'expense'
            ]);

            $table->string('name');
            $table->bigInteger('amount');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('job_id')->nullable();
            $table->boolean('received');
            $table->boolean('excluded');

            $table->text('notes')->nullable();

            $table->index('type');
            $table->index('account_id');
            $table->index('job_id');
            $table->index('received');
            $table->index('excluded');

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');

            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
                ->onDelete('cascade');

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
        Schema::dropIfExists('transactions');
    }
}
