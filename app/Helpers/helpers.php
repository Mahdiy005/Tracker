<?php

function getRandomString(array $strings)
{
    if (empty($strings)) {
        return null; // Return null if the array is empty
    }
    return $strings[array_rand($strings)];
}


function getEnumsValue($enum)
{
    return array_map(fn ($case) => $case->value, $enum);
}