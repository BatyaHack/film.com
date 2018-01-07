<?php

namespace App\Http\Controllers;

use App\film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    private $URL_SITE =
        "http://www.omdbapi.com/?apikey=c585f45d&t=";

    public function find($title, Request $request) {

       if(film::checkFilm($title)) {
           // TODO Отправлять тот фильм, который нашел при проверке. Опять же поправить checkFilm
           return "Film in DB";
       }

        $title = $this->toCorrectUrl($title);

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
        film::createFromJson($film_data);
        // TODO Отправлять только что созданный эллмент. Для этого нужно поправить createFromJson
        return "OK";

        // TODO Наверное, нужно сделать какой то ответ, если я вообще ничего не нашел!
    }


    private function toCorrectUrl($title) {
        $correct_title = trim($title);
        $correct_title_array = explode(" ", $correct_title);
        return implode("+", $correct_title_array);
    }
}
