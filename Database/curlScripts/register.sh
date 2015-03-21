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

email=$3;
isEmpty "email" $email;


curl --data \
    "username=$username&password=$password&email=$email" \
    http://localhost/NextSemesters/Database/register.php
