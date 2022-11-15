<?php


require 'vendor/autoload.php';

use Apto1\TranslateScrapper\Scrapper;
use Apto1\TranslateScrapper\Dictionary;

const URLS = [
    13 => [
        'en'	=> 'https://herema.gr/who-we-are/our-mandate/',
        'gr'	=> 'https://herema.gr/el/who-we-are/our-mandate/',
    ],
    14 => [
        'en'	=> 'https://herema.gr/who-we-are/our-transformation/',
        'gr'	=> 'https://herema.gr/el/who-we-are/our-transformation/',
    ],
];

$scrapper = new Scrapper(URLS);


$dictionary = new Dictionary('gr');
$dictionary->search('Με πυξίδα την πεποίθηση ότι η εταιρεία');
var_dump($dictionary->getPerformance());
var_dump($dictionary->getResult());
var_dump($dictionary->getDictionary());
//var_dump($scrapper->getDebugResults());