<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 15)->unique();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('correo', 100)->unique();
            $table->string('telefono', 15);
            $table->string('direccion', 150);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
