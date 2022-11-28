<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This file is part of DTM-PHP.
 *
 * @license  https://github.com/dtm-php/dtm-client/blob/master/LICENSE
 */


class AddCreateBarrierTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barrier', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('trans_type', 45)->default('');
            $table->string('gid', 128)->default('');
            $table->string('branch_id', 128)->default('');
            $table->string('op', 45)->default('');
            $table->string('barrier_id', 45)->default('');
            $table->string('reason', 45)->default('')->comment('the branch type who insert this record');
            $table->dateTime('create_time')->useCurrent();
            $table->dateTime('update_time')->useCurrent();
            $table->index('create_time');
            $table->index('update_time');
            $table->unique(['gid', 'branch_id', 'op', 'barrier_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barrier');
    }
}
