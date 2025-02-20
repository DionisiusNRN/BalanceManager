<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('transaction_number')->nullable()->after('id');
        });

        // Isi transaction_number berdasarkan urutan per user_id
        DB::statement('
            UPDATE transactions AS t1
            JOIN (
                SELECT id, user_id, ROW_NUMBER() OVER (PARTITION BY user_id ORDER BY id) AS new_id
                FROM transactions
            ) AS t2 ON t1.id = t2.id
            SET t1.transaction_number = t2.new_id
        ');

        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('transaction_number')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_number');
        });
    }
};
