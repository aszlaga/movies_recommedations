<?php
require_once dirname(__FILE__) . '/src/movieRecommendations.php';

$recommendation = new \src\MovieRecommendations();

echo "### (^_^) WELCOME TO THE MOVIES SELECTOR @Olo ####";
echo "<hr>";

var_dump( '<pre>', [ 
    '3 random movies titles'            => $recommendation->get3RandomTitles(),
    'Start with w/W and even letters'   => $recommendation->getTitlesWithEvensLettersStartsW(),
    'With minimum 2 words'              => $recommendation->getTitlesWithMultipleWords()
        ], '</pre>' );