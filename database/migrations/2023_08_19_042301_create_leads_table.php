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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('unique_query_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('number')->nullable();
            $table->string('contact_person')->nullable();
            $table->text('scope_activity')->nullable();
            $table->string('allocate_user')->nullable();
            $table->string('standard_id')->nullable();
            $table->string('accreditation_id')->nullable();
            $table->string('amount')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('status_id')->nullable();
            $table->enum('gst', ['w', 'o'])->nullable();
            $table->enum('additional_options', ['i', 'e'])->nullable();
            $table->timestamp('date')->nullable();
            $table->string('lead_source_id')->nullable();
            $table->string('lead_source_text')->nullable();
            $table->string('sender_company')->nullable();
            $table->string('sender_state')->nullable();
            $table->string('sender_pincode')->nullable();
            $table->string('sender_country_iso')->nullable();
            $table->string('sender_mobile_alt')->nullable();
            $table->string('sender_phone')->nullable();
            $table->string('sender_phone_alt')->nullable();
            $table->string('sender_email_alt')->nullable();
            $table->string('query_product_name')->nullable();
            $table->text('comment')->nullable();
            $table->string('query_mcat_name')->nullable();
            $table->string('call_duration')->nullable();
            $table->string('receiver_mobile')->nullable();
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
        Schema::dropIfExists('leads');
    }
};