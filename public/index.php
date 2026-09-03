<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Models\User;

$user = new User('felipe', 'fe@gmail.com');

echo $user->getName();
echo '<br>';
echo $user->getEmail();