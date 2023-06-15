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
        Schema::create('categorie_product', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("categorie_id");
            $table->foreign("categorie_id")->references("id")->on("categories")->onDelete("cascade");

            $table->unsignedBigInteger("product_id");
            $table->foreign("product_id")->references("code")->on("products")->onDelete("cascade");
            
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
        Schema::dropIfExists('categorie_product');
    }
};
