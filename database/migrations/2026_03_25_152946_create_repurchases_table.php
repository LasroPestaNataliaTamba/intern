<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repurchases', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('qty');
            $table->decimal('price', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('supplier');
            $table->string('proof_pdf')->nullable();
            $table->string('bank_account');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repurchases');
    }
};
