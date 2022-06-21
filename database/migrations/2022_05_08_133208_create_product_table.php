<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Description');
            $table->integer('Barcode');
            $table->string('Type');
            $table->date('DatePurchase');
            $table->double('Quantity');
            $table->double('PriceBuy');
            $table->double('PriceSelling');
            $table->integer('Validity');
            $table->string('Image');
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
        Schema::dropIfExists('product');
    }
};
