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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('facility_code')->unique();
            $table->string('name')->unique();
            $table->string('prefecture')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code', 7)->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->date('opening_date')->nullable();
            $table->string('business_type')->nullable();
            $table->integer('capacity')->nullable();
            $table->decimal('floor_area', 10, 2)->nullable();
            $table->string('building_structure')->nullable();
            $table->integer('construction_year')->nullable();
            $table->string('land_ownership')->nullable();
            $table->string('building_ownership')->nullable();
            $table->date('lease_start_date')->nullable();
            $table->date('lease_end_date')->nullable();
            $table->decimal('lease_monthly_rent', 12, 2)->nullable();
            $table->string('management_company')->nullable();
            $table->string('fire_insurance_company')->nullable();
            $table->date('fire_insurance_start_date')->nullable();
            $table->date('fire_insurance_end_date')->nullable();
            $table->string('earthquake_insurance_company')->nullable();
            $table->date('earthquake_insurance_start_date')->nullable();
            $table->date('earthquake_insurance_end_date')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('region_id')->nullable()->constrained()->onDelete('set null');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};