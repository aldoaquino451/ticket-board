<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::disableForeignKeyConstraints();

    Schema::create('tickets', function (Blueprint $table) {
      $table->id();
      $table->char('code', 10)->unique();
      $table->unsignedBigInteger('operator_id')->nullable();
      $table->foreign('operator_id')->references('id')->on('operators')->onDelete('set null');
      $table->unsignedBigInteger('category_id')->nullable();
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
      $table->string('title', 255);
      $table->text('description');
      $table->enum('status', ["queued", "assigned", "in progress", "closed"]);
      $table->timestamps();
    });

    Schema::enableForeignKeyConstraints();
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tickets');
  }
};
