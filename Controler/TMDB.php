<?php
class TMDB {
    private $apiKey;
    private static $clientInstance;

    public static function getInstance() {
      if (self::$clientInstance == null) {
          self::$clientInstance = new \GuzzleHttp\Client(['verify' =>false]);
      }

      return self::$clientInstance;
  }

    public static function searchMovies($movieName) {
        $url = 'https://api.themoviedb.org/3/search/movie?query=' . $movieName . '&include_adult=false&language=en-US&page=1';
        return self::getRequest($url)->results;
    }

    public static function getDetails($movieID){
      $url = 'https://api.themoviedb.org/3/movie/' . $movieID . '?language=en-US';
      return self::getRequest($url);
    }

    public static function getCredits($movieID){
      $url = 'https://api.themoviedb.org/3/movie/' . $movieID . '/credits?language=en-US';
      return self::getRequest($url);
    }

    public static function getDirectors($movieID){
      $credits = self::getCredits($movieID);
      $directors = [];
      foreach ($credits->crew as $member) {
        if ($member->job == 'Director') {
          $directors[] = $member->name;
        }
      }
      return $directors;
    }

    public static function getGenres($movieID){
      $details = self::getDetails($movieID);
      $genres = [];
      foreach ($details->genres as $genre) {
        $genres[] = $genre->name;
      }
      return $genres;
    }

    public static function getMovie($movieID){
      $details = self::getDetails($movieID);
      $directors = self::getDirectors($movieID);
      $genres = self::getGenres($movieID);
      return [
        'title' => $details->title,
        'release_date' => $details->release_date,
        'original_language' => $details->original_language,
        'overview' => $details->overview,
        'poster_path' => $details->poster_path,
        'directors' => $directors,
        'genres' => $genres,
      ];
    }


    public static function getRequest($url){
      $response = self::getInstance()->request('GET', $url, [
        'headers' => [
          'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0MzVkYTk5OTZhM2E3NjJiM2FhM2M3ZDI5NTJhOTM5MiIsInN1YiI6IjY1ZGVmMDE3NzYxNDIxMDE2MmQ0ZjdkYyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.ROSifJ3sawYVZdLTKQ9Dpsb37PluSyBn8UeNaXAd23I',
          'accept' => 'application/json',
        ],
      ]);
      return json_decode($response->getBody());
    }
}
