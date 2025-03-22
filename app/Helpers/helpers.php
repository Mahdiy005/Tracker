<?php

use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

function getRandomString(array $strings)
{
    if (empty($strings)) {
        return null; // Return null if the array is empty
    }
    return $strings[array_rand($strings)];
}


function getEnumsValue($enum)
{
    return array_map(fn($case) => $case->value, $enum);
}

// Generate Random Serial
function generateSerial()
{
    $maxAttempts = 100; // Maximum number of attempts to generate a unique serial
    $attempt = 0;

    // Start with the initial serial number
    $serial = IdGenerator::generate([
        'table' => 'users',
        'field' => 'serial',
        'length' => 15,
        'prefix' => 'TRACKER-',
    ]);

    while ($attempt < $maxAttempts) {
        // Check if the serial number already exists in the database
        $exists = DB::table('users')->where('serial', $serial)->exists();

        if (!$exists) {
            return $serial; // Return the unique serial number
        }

        // If the serial exists, increment the numeric part
        $numericPart = (int) preg_replace('/[^0-9]/', '', $serial); // Extract numeric part
        $numericPart++; // Increment the numeric part
        $serial = 'TRACKER-' . str_pad($numericPart, 15 - strlen('TRACKER-'), '0', STR_PAD_LEFT); // Generate new serial

        $attempt++;
    }

    throw new Exception("Unable to generate a unique serial number after $maxAttempts attempts.");
}
