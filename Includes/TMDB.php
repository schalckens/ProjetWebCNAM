<?php

class TMDB {
    private $apiKey;
    private static $clientInstance;

    public static function getInstance() {
      if (self::$clientInstance == null) {
          self::$clientInstance = new GuzzleHttp\Client(['verify' =>false]);
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

    public static function getActors($movieID, $limit = 10){
      $credits = self::getCredits($movieID);
      $actors = [];
      foreach ($credits->cast as $index => $member) {
        if ($index >= $limit) {
          break;
        }
        $actors[] = [
          'name' => $member->name,
          'profile_path' => $member->profile_path,
        ];
      }
      return $actors;
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
      $countries = [];
      $productionCompanies = [];
      $actors = self::getActors($movieID);

      if (isset($details->production_countries)) {
        foreach ($details->production_countries as $country) {
          $countries[] = $country->name;
        }
      }

      if (isset($details->production_companies)) {
        foreach ($details->production_companies as $company) {
          $productionCompanies[] = [
            'name' => $company->name,
            'logo_path' => $company->logo_path,
            'origin_country' => $company->origin_country,
          ];
        }
      }

      return [
        'title' => $details->title,
        'release_date' => $details->release_date,
        'original_language' => $details->original_language,
        'overview' => $details->overview,
        'poster_path' => $details->poster_path,
        'directors' => $directors,
        'genres' => $genres,
        'countries' => $countries,
        'production_companies' => $productionCompanies,
        'actors' => $actors,
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
