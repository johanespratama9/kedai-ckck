<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->after('paid_at');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            $table->enum('approval_status', ['pending_approval', 'approved', 'rejected'])->default('pending_approval')->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approval_status');
            
            // Foreign key constraint
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeignIdFor('users', 'approved_by');
            $table->dropColumn(['approved_at', 'approved_by', 'approval_status', 'rejection_reason']);
        });
    }
};
