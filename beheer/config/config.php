<?php

// Configuration file.
// Please do not commit changes you've made to make it work on your own environment.

global $config;
global $mailItems;

$config = [
    "fullURL" => "http://localhost/Bed&Breakfast/", //de basis url. dit zal de website worden wanneer het op een server staat.

    "apiKey" => "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", // dit is de apikey van sendgrid.
];

//wachtwoord vergeten
$mailItems = [
    "from"      => "jw.huising@gmail.com",
    "subject"   => "Wachtwoord reset",
    "body"      => "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website www.yoursitehere.com\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n",

];
$verifyAccount = [
    "subject" => "Email verificatie",
    "body" => "Beste gebruiker,\n\nals deze mail niet voor jou geldt negeer hem dan a.u.b. Je hebt een account aangemaakt bij Xtern-IT.\n\nOm je account te activeren klik op de link beneden.\nAls je niet op de link kan klikken, plak hem dan in je adress balk.\n\n"
];

