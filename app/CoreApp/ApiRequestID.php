<?php

namespace App\CoreApp;

use App\CoreApp\AbstractClass\AbstractCreated;
use App\film;

// для id
class ApiRequestID extends AbstractCreated
{
    protected $URL =
        "http://www.omdbapi.com/?apikey=c585f45d&i=";

    public function __construct()
    {

    }

    public function getFilm($id)
    {
        if ($find_filmDb = film::checkFilmById($id)) {
            return $find_filmDb;
        }
        $film_data = $this->executeApi($id);
        $new_film = film::create($film_data);
        return $new_film;
    }
}