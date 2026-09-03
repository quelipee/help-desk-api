<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Models\User;
use App\ValueObjects\Email;

$email = new Email('fe@gmail.com');
$user = new User(1,'felipe', $email);

$user->changeEmail(new Email('fe12@gmail.com'));
$user->changeName('felipe Mateus');

echo $user->getId();
echo '<br>';
echo $user->getName();
echo '<br>';
echo $user->getEmail();
echo '<br>';