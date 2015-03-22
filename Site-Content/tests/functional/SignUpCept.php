<?php 

$I = new FunctionalTester($scenario);
$I->am('a guest');
$I->wantTo('sign up for NextSemester account');

$I->amOnPage('/');
$I->click('Sign Up');
$I->seeCurrentUrlEquals('/register');

$I->fillField('Username:', "JonLysiak");
$I->fillField('Email:', "jon@example.com");
$I->fillField('Password:', "demo");
$I->fillField('Password Confirmation:', "demo");
$I->click('Sign Up');

$I->seeCurrentUrlEquals('');
$I->see('Welcome to NextSemester');

$I->seeRecord('users', [
	'username' => 'JonLysiak',
	'email' => 'jon@example.com'
]);

$I->assertTrue(Auth::check());