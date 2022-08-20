<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('transaction_id')->nullable();

            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->string('package_type')->nullable();
            $table->integer('duration')->default(90);
            $table->string('sub_total')->nullable();
            $table->string('shipping')->default(0);
            $table->string('offers')->nullable();
            $table->string('total')->nullable();
            $table->string('bein_card_number')->nullable();

            $table->integer('status')->default(0);
            $table->timestamps();
            // $table->id();
            // $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            // $table->string('first_name')->nullable();
            // $table->string('last_name')->nullable();
            // $table->string('country')->nullable();
            // $table->string('address')->nullable();
            // $table->string('city')->nullable();
            // $table->string('zip_code')->nullable();
            // $table->string('mobile')->nullable();
            // $table->string('email')->nullable();
            // $table->string('transaction_id')->nullable();
            // $table->string('sub_total')->nullable();
            // $table->string('shipping')->default(0);
            // $table->string('offers')->default(0);
            // $table->string('total')->nullable();
            // $table->integer('status')->default(0);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
