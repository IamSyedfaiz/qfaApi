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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
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
            $table->string('date')->nullable();
            $table->string('lead_source_id')->nullable();
            $table->string('lead_source_text')->nullable();
            $table->text('comment')->nullable();
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
