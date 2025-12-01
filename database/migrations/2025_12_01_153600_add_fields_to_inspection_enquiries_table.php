<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspection_enquiries', function (Blueprint $table) {
            $table->string('status')->nullable()->after('inspector_id');
            $table->text('comment')->nullable()->after('status');
            $table->text('comment_initial')->nullable()->after('comment');
            $table->decimal('asking_price')->nullable()->after('comment_initial');
            $table->decimal('offer_price')->nullable()->after('comment_initial');
        });
    }

    public function down(): void
    {
        Schema::table('inspection_enquiries', function (Blueprint $table) {
            $table->dropColumn(['status', 'comment', 'comment_initial', 'asking_price','offer_price']);
        });
    }
};
