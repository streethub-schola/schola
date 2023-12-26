<?php

function cleanData($data){
    return htmlspecialchars(strip_tags(trim($data)));
}