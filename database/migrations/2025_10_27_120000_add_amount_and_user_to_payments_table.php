<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'Amount')) {
                $table->decimal('Amount', 10, 2)->default(0)->after('TransactionID');
            }

            if (!Schema::hasColumn('payments', 'UserID')) {
                $table->foreignId('UserID')
                    ->nullable()
                    ->after('Amount')
                    ->constrained('users', 'UserID')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'UserID')) {
                $table->dropForeign(['UserID']);
                $table->dropColumn('UserID');
            }

            if (Schema::hasColumn('payments', 'Amount')) {
                $table->dropColumn('Amount');
            }
        });
    }
};
