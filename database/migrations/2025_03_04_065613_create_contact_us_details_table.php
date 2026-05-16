<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsDetailsTableV2 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('contact_us_details')) {
            Schema::create('contact_us_details', function (Blueprint $table) {
                $table->id();
                $table->text('address');
                $table->string('phone');
                $table->string('email');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('contact_us_details');
    }
}
