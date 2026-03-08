<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::connection('mongodb')->hasTable('users')) {
            Schema::connection('mongodb')->create('users', function (Blueprint $collection) {
                $collection->unique('email');
                $collection->index('created_at');
            });
        }

        if (! Schema::connection('mongodb')->hasTable('admins')) {
            Schema::connection('mongodb')->create('admins', function (Blueprint $collection) {
                $collection->unique('email');
                $collection->index('created_at');
            });
        }

        Schema::connection('mongodb')->table('tasks_collection', function (Blueprint $collection) {
            $collection->index(['owner_guard', 'owner_id']);
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('admins');
        Schema::connection('mongodb')->dropIfExists('users');
    }
};
