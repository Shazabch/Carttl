<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inspection_reports', function (Blueprint $table) {
            $table->id();

            // Optional link back to the enquiry that started this inspection
            $table->foreignId('inspection_enquiry_id')->nullable();

            // --- Vehicle Details (Stored directly in this report) ---
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('year', 4)->nullable();
            $table->string('vin')->nullable();
            $table->string('odometer')->nullable();
            $table->string('color')->nullable();
            // ... any other core vehicle details you want to capture

            // Foreign key to the user who performed the inspection
            $table->foreignId('vehicle_id')->nullable();
            $table->foreignId('inspector_id')->nullable();
            $table->timestamp('inspected_at')->useCurrent();

            // == General Condition ==
            $table->string('warrantyAvailable')->nullable();
            $table->string('serviceContractAvailable')->nullable();
            $table->string('serviceHistory')->nullable();
            $table->string('noOfKeys')->nullable();
            $table->string('mortgage')->nullable();
            $table->string('registrationUpToDate')->nullable();
            $table->string('accidentHistory')->nullable();
            $table->string('overallCondition')->nullable();

            // == Exterior ==
            $table->text('paintCondition')->nullable(); // JSON array
            $table->string('convertible')->nullable();
            $table->string('blindSpot')->nullable();
            $table->string('wheelsType')->nullable();
            $table->string('rimsSizeFront')->nullable();
            $table->string('rimsSizeRear')->nullable();
            $table->string('sideSteps')->nullable();

            // == Tires ==
            $table->string('tiresSize')->nullable();
            $table->string('spareTire')->nullable();
            $table->text('frontLeftTire')->nullable(); // JSON array
            $table->text('frontRightTire')->nullable(); // JSON array
            $table->text('rearLeftTire')->nullable(); // JSON array
            $table->text('rearRightTire')->nullable(); // JSON array

            // == Car Specs (Features) ==
            $table->string('parkingSensors')->nullable();
            $table->string('keylessStart')->nullable();
            $table->string('seats')->nullable(); // Material: Leather, Fabric
            $table->string('cooledSeats')->nullable();
            $table->string('heatedSeats')->nullable();
            $table->string('powerSeats')->nullable();
            $table->string('viveCamera')->nullable();
            $table->string('sunroofType')->nullable();
            $table->string('drive')->nullable();

            // == Interior, Electrical & Air Conditioner ==
            $table->string('speedmeterCluster')->nullable();
            $table->string('headLining')->nullable();
            $table->string('seatControls')->nullable();
            $table->text('seatsCondition')->nullable(); // JSON array
            $table->string('centralLockOperation')->nullable();
            $table->string('sunroofCondition')->nullable();
            $table->string('windowsControl')->nullable();
            $table->string('cruiseControl')->nullable();
            $table->string('acCooling')->nullable();

            // == Engine & Transmission ==
            $table->string('engineOil')->nullable();
            $table->string('gearOil')->nullable();
            $table->string('engineCondition')->nullable();
            $table->string('transmissionCondition')->nullable();
            $table->string('engineNoise')->nullable();
            $table->string('engineSmoke')->nullable();
            $table->string('fourWdSystemCondition')->nullable();
            $table->string('obdError')->nullable();

            // == Steering, suspension & Brakes ==
            $table->string('steeringOperation')->nullable();
            $table->string('wheelAlignment')->nullable();
            $table->string('brakePads')->nullable();
            $table->text('brakeDiscs')->nullable(); // JSON array
            $table->string('suspension')->nullable();
            $table->text('shockAbsorberOperation')->nullable(); // JSON array

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_inspection_reports');
    }
};