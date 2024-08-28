<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('email')->unique();
            $table->string('amout');
            $table->string('paid');
            $table->date('due_date');

            // 1 => مدفوعه
            // 2 => غير مدفوعه
            // 3 =>  مدفوعه جزئيا
            $table->enum('status', [1, 2, 3]);
            $table->string('payment_method');
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
        Schema::dropIfExists('invoices');
    }
}
