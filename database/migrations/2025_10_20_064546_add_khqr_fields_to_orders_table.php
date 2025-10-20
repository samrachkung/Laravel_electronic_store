<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('khqr_transaction_id')->nullable()->after('stripe_session_id');
            $table->text('khqr_qr_code')->nullable()->after('khqr_transaction_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['khqr_transaction_id', 'khqr_qr_code']);
        });
    }
};
