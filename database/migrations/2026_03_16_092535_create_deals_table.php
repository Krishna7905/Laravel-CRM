<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->foreignId('contact_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('value',10,2);

            $table->enum('stage',[
                'new',
                'contacted',
                'proposal',
                'negotiation',
                'won',
                'lost'
            ])->default('new');

            $table->date('close_date')->nullable();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
