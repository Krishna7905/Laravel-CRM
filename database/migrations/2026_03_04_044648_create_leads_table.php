<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();

            $table->enum('status',[
                'new',
                'contacted',
                'qualified',
                'proposal',
                'converted',
                'lost'
            ])->default('new');

            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
};