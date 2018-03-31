<?php

namespace App\CoreApp;

use App\CoreApp\AbstractClass\AbstractCreated;
use App\film;

// для тайтла
class ApiRequestTitle extends AbstractCreated
{
    protected $URL =
        "http://www.omdbapi.com/?apikey=c585f45d&t=";

    public function __construct()
    {

    }

    public function getFilm($title)
    {
        if ($find_filmDb = film::checkFilm($title)) {
            return [$find_filmDb, 'findFlag' => false];
        }
        $film_data = $this->executeApi($title);
        $new_film = film::create($film_data);
        return [$new_film, 'findFlag' => true];
    }


}