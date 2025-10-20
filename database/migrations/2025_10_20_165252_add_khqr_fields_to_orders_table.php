<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('khqr_code')->nullable()->after('stripe_session_id');
            $table->string('khqr_md5')->nullable()->after('khqr_code');
            $table->timestamp('khqr_expires_at')->nullable()->after('khqr_md5');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['khqr_code', 'khqr_md5', 'khqr_expires_at']);
        });
    }
};
