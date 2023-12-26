<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('lead_id')->nullable();
            $table->string('standard_name')->nullable();
            $table->string('standard_description')->nullable();
            $table->string('certificate_template')->nullable();
            $table->enum('certificate_status', ['D', 'F'])->default('D');
            $table->string('business_name')->nullable();
            $table->text('business_name_secondary')->nullable();
            $table->text('scope_registration')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('date_initial')->nullable();
            $table->string('first_surveillance_audit')->nullable();
            $table->string('second_surveillance_audit')->nullable();
            $table->string('certification_due_date')->nullable();
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
        Schema::dropIfExists('certificates');
    }
};
