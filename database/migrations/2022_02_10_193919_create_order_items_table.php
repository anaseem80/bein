<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('order_items', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        //     $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
        //     $table->string('package_type')->nullable();
        //     $table->integer('duration')->default(90);
        //     $table->string('price')->nullable();
        //     $table->string('offer')->nullable();
        //     $table->string('total_price')->nullable();
        //     $table->string('bein_card_number')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
