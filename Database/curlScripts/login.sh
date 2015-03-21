#!/bin/bash

isEmpty(){

    param=$1;
    arg=$2;
    
    if [ -z "$arg" ]; then 
        echo "Error: $param is empty" >&2;
        exit;
    fi

}

username=$1;
isEmpty "username" $username;

password=$2;
isEmpty "password" $password;


curl --data \
    "username=$username&password=$password" \
    http://localhost/NextSemesters/Database/login.php
