<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detalle_facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained()->onDelete('cascade');
            $table->foreignId('producto_id')->constrained();
            $table->integer('cantidad');
            $table->decimal('precio',8,2);
            $table->decimal('subtotal',8,2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_facturas');
    }
};

