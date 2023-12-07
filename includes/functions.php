<?php
// Function to calculate age based on date of birth
function calculateAge($dob)
{
    $today = new DateTime();
    $birthdate = new DateTime($dob);
    $age = $today->diff($birthdate)->y;
    return $age;
}
