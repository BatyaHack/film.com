<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmController extends Controller
{
    private $URL_SITE =
        "http://www.omdbapi.com/?apikey=c585f45d&t=";

    public function find($title, Request $request) {

        $defaults = array(
            CURLOPT_URL => $this->URL_SITE . $title, // куда идем
            CURLOPT_HEADER => 0, // заголовки
            CURLOPT_RETURNTRANSFER => TRUE, // вернуть контент, а не инфу удачно не удачно
            CURLOPT_TIMEOUT => 4 // время которое ждем
        );

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $film_data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $film_data['Title'] . " " . $film_data['Year'];
    }
}
