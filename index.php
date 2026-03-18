<?php

use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\eMode;
use Lucasjs7\SimpleValidator\Type\_String;

include 'vendor/autoload.php';

Core::$mode = eMode::DEBUG;

echo _String::new()->min(1)->options('te')->info();

