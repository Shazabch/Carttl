<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakeUsersStatusNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('users', 'status')) {
            return;
        }

        try {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status')->nullable()->default('pending')->change();
            });
        } catch (\Throwable $e) {
            // Fallback for installations without doctrine/dbal: use raw SQL
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `users` MODIFY `status` VARCHAR(255) NULL DEFAULT 'pending'");
            } elseif ($driver === 'pgsql') {
                DB::statement("ALTER TABLE users ALTER COLUMN status DROP NOT NULL");
                DB::statement("ALTER TABLE users ALTER COLUMN status SET DEFAULT 'pending'");
            } else {
                // Last resort: rethrow so migration fails visibly
                throw $e;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasColumn('users', 'status')) {
            return;
        }

        try {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status')->nullable(false)->default('pending')->change();
            });
        } catch (\Throwable $e) {
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `users` MODIFY `status` VARCHAR(255) NOT NULL DEFAULT 'pending'");
            } elseif ($driver === 'pgsql') {
                DB::statement("ALTER TABLE users ALTER COLUMN status SET NOT NULL");
                DB::statement("ALTER TABLE users ALTER COLUMN status SET DEFAULT 'pending'");
            } else {
                throw $e;
            }
        }
    }
}
