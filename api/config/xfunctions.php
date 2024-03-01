<?php

// checks for admin
function isAdmin($role){

    if($role != null && !empty($role) && $role == "admin") return true;
    return false;
}

// checks for admin
function isStaff($role){

    if($role != null && !empty($role) && $role == "staff") return true;
    return false;
}

// checks for admin
function isTeacher($role){

    if($role != null && !empty($role) && $role == "teacher"){
        return true;
    } 
    return false;
}

// checks for admin
function isPrincipal($role){

    if($role != null && !empty($role) && $role == "principal") return true;
    return false;
}

// checks for admin
function isLoggedIn(){

    
}

// checks for admin
function isStudent($role){

    if($role != null && !empty($role) && $role == "student") return true;
    return false;
}