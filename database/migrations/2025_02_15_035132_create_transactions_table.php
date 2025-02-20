<?php
// dev-restful2 start here

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang input
            $table->date('date'); // Tanggal Transaksi
            $table->decimal('amount',15,2); // Nominal uang
            $table->enum('type', ['income', 'expense']); // Jenis (pemasukan atau pengeluaran)
            $table->string('description')->nullable(); // Keterangan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
