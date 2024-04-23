<?php

use PHPUnit\Framework\TestCase;
use src\MovieRecommendations;

class MovieRecommendationsTest extends TestCase
{
    private $recommendations;

    public function setUp(): void
    {
        $this->recommendations = new MovieRecommendations();
    }

    public function testGet3RandomTitles(): void
    {
        $selectedMovies = $this->recommendations->get3RandomTitles();

        // if somwhere movies are less than 3...
        if( ( $allMoviesQty = count( $this->recommendations->movies ) ) < 3 )
        {
            $this->assertCount( $allMoviesQty, $selectedMovies );
        }
        // in other situation
        else
        {
            $this->assertCount( 3, $selectedMovies );
        }
        
        // check all movies are in our list
        foreach( $selectedMovies as $movie )
        {
            $this->assertContains( $movie, $this->recommendations->movies );
        }
        
        // check values are unique
        $this->assertUniqueValues( $selectedMovies );
    }

    public function testGetTitlesWithEvensLettersStartsW(): void
    {
        $selectedMovies = $this->recommendations->getTitlesWithEvensLettersStartsW();

        foreach( $selectedMovies as $movie )
        {
            // check the string starts with 'W' letter
            $this->assertStringStartsWith( 'W', $movie );
            // checks if the title contains an even number of characters
            $this->assertIsEven( $movie );
        }
    }

    public function testGetTitlesWithMultipleWords(): void
    {
        $selectedMovies = $this->recommendations->getTitlesWithMultipleWords();

        foreach( $selectedMovies as $movie )
        {
            preg_match_all( '/\b[\p{L}\p{N}\p{P}\p{S}]+\b/u', $movie, $matchedWords );

            if( isset( $matchedWords[ 0 ] ) && ( $wordsQty = count( $matchedWords[ 0 ] ) ) > 1 )
            {
                // Checks the title contains more than one word
                $this->assertGreaterThanOrEqual( 2, $wordsQty );
            }
            else
            {
                $this->fail(  "The title '{$movie}' has less than 2 words!" );
            }
        }
    }
    
    /**
     * Assert values in array are unique
     *  
     * @param array $array
     * @return void
     */
    private function assertUniqueValues( array $array ) : void
    {
        $uniqueValues = [];
        
        foreach( $array as $value )
        {
            if( in_array( $value, $uniqueValues ) )
            {
                $this->fail( "The value '{$value}' isn't unique - duplicated value in array" );
            }
            
            $uniqueValues[] = $value;
        }
    }
    
    /**
     * Asserts that string has even numerb of characters
     * 
     * @param string $string
     * @return void
     */
    private function assertIsEven( string $string ) : void
    {
        if( mb_strlen( $string ) % 2 )
        {
            $this->fail( "Not even number of characters: '{$string}'" );
        }
    }
}
