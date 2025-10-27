<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'CardType')) {
                $table->string('CardType', 20)->nullable()->after('UserID');
            }

            if (!Schema::hasColumn('payments', 'CardLastFour')) {
                $table->string('CardLastFour', 4)->nullable()->after('CardType');
            }

            if (!Schema::hasColumn('payments', 'CardExpMonth')) {
                $table->unsignedTinyInteger('CardExpMonth')->nullable()->after('CardLastFour');
            }

            if (!Schema::hasColumn('payments', 'CardExpYear')) {
                $table->unsignedSmallInteger('CardExpYear')->nullable()->after('CardExpMonth');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            foreach (['CardType', 'CardLastFour', 'CardExpMonth', 'CardExpYear'] as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
