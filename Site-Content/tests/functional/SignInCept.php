<?php 

$I = new FunctionalTester($scenario);

$I->am('a NextSemester member');
$I->wantTo('login to my NextSemester account');

$I->signIn();

$I->seeInCurrentUrl('/statuses');
$I->see('Welcome back!'); 
$I->assertTrue(Auth::check());