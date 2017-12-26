<?php

require 'encrypt-decrypt.php';

$key       = 'letmein';
$raw       = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
$meta      = [ 'name' => 'Rich', 'email' => 'rich@richjenks.com' ];
$encrypted = encrypt($key, $raw, $meta);
$decrypted = decrypt($key, $encrypted, $meta);

echo 'KEY:';
var_dump($key);
echo 'RAW:';
var_dump($raw);
echo 'META:';
var_dump($meta);
echo 'ENCRYPTED:';
var_dump($encrypted);
echo 'DENCRYPTED:';
var_dump($decrypted);



?>