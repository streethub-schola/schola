<?php

$input = "<h1>TEST<?h1>";

$output = trim(strip_tags($input));

echo $output;