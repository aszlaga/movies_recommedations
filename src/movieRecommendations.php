<?php
namespace src;

require_once dirname(__FILE__) . '/movies.php';

/**
 * Movie Recommendations class.
 * Provides 3 selectable algorithms of movies titles.
 * 
 * @author Aleksander Szlaga <olo8687@gmail.com>
 * @version 1.0
 * @since 23.04.2024
 */
class MovieRecommendations extends MoviesData
{
    /**
     * Get 3 random movie titles. 
     * If the library will be shorter than 3 then get all of them
     * 
     * @return array
     */
    public function get3RandomTitles(): array
    {
        $titles    = [];
        $titlesQty = count( $this->movies );

        // if less than 3 then return these all I guess ;]
        // only the feature if the nr of titles should be dynammically loaded
        if( $titlesQty < 3 )
        {
            return $this->movies;
        }
        
        // compose unique elements - 3 max
        while( count( $titles ) < 3 )
        {
            $index = random_int( 0, $titlesQty );
            
            if( isset( $this->movies[ $index ] ) && !in_array( $this->movies[ $index ], $titles ) )
            {
                $titles[] = $this->movies[ $index ];
            }
        }

        return $titles;
    }

    /**
     * Get all movies titles starts with "W" letter and with even qty of letters
     * 
     * Note: We assume that we count all characters, blanks, dots, dashes, etc.
     * 
     * @return array
     */
    public function getTitlesWithEvensLettersStartsW(): array
    {
        $movies = [];

        foreach( $this->movies as $movie )
        {
            if( mb_strpos( $movie, 'W', 0 ) === 0 && mb_strlen( $movie ) % 2 === 0 )
            {
                $movies[] = $movie;
            }
        }

        return $movies;
    }

    /**
     * Get all movies with more than 1 word in title
     * 
     * Note: We assume that on word can be one letter or
     * 
     * @return array
     */
    public function getTitlesWithMultipleWords(): array
    {
        $selectedMovies = [];

        foreach( $this->movies as $movie )
        {
            preg_match_all( '/\b[\p{L}\p{N}\p{P}\p{S}]+\b/u', $movie, $matchedWords );
            
            if( isset( $matchedWords[ 0 ] ) && count( $matchedWords[ 0 ] ) > 1 )
            {
                $selectedMovies[] = $movie;
            }
        }

        return $selectedMovies;
    }
}