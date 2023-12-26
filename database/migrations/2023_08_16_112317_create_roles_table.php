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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('lead', ['Y', 'N'])->default('N');
            $table->enum('user', ['Y', 'N'])->default('N');
            $table->enum('meeting', ['Y', 'N'])->default('N');
            $table->enum('proposal', ['Y', 'N'])->default('N');
            $table->enum('certificate', ['Y', 'N'])->default('N');
            $table
                ->enum('certificate_option', ['Q', 'H', 'I'])
                ->nullable()
                ->default(null);
            $table->enum('account', ['Y', 'N'])->default('N');
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
        Schema::dropIfExists('roles');
    }
};
