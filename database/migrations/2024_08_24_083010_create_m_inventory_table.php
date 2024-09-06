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
      Schema::create('m_inventory', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
            $table->integer('item_id');
            $table->integer('uom_id');
            $table->text('description')->nullable();
            $table->date('entry_date');
            $table->date('expiry_date')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->decimal('purchase_price', 10, 2)->default(0.00);
            $table->decimal('sale_price', 10, 2)->default(0.00);
            $table->string('status')->default('active');
            $table->integer('minimum_stock')->default(0);
            $table->integer('maximum_stock')->default(0);
            $table->string('supplier')->nullable();
            $table->integer('order_quantity')->default(0);
            $table->integer('sold_quantity')->default(0);
            $table->text('notes')->nullable();
            $table->string('created_who')->nullable();
            $table->string('change_who')->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_inventory');
    }
};
