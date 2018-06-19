<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('vendor_id')->unsigned()->index();
            $table->integer('dealer_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->float('price')->default(0);
            $table->float('width')->default(0);
            $table->float('height')->default(0);
            $table->float('depth')->default(0);
            $table->float('weight')->default(0);
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('parent_id')->unsigned()->index();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('contact_id')->unsigned()->index();
            $table->string('name');
            $table->string('short_name');
            $table->timestamps();
        });
        Schema::create('dealers', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('contact_id')->unsigned()->index();
            $table->string('name');
            $table->string('short_name');
            $table->timestamps();
        });
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('name');
            $table->string('telephone')->default('+1(234)567-89-10');
            $table->string('email')->default('e@mail.ru');
            $table->string('site')->default('www.site.ru');
            $table->string('location')->default('City');
            $table->timestamps();
        });
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->integer('attribute_name_id')->unsigned()->index();
            $table->string('value');
            $table->timestamps();
        });
        Schema::create('attribute_names', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->string('name');
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('dealers');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_names');
    }
}
