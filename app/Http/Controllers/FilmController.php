<?php

namespace App\Http\Controllers;

use App\CoreApp\ApiRequest;
use App\film;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    private $URL_SITE =
        "http://www.omdbapi.com/?apikey=c585f45d&t=";

    public function find($title, Request $request, ApiRequest $api_Request)
    {

        try {
            if ($find_filmDb = film::checkFilm($title)) {
                return $find_filmDb;
            }

            $film_data = $api_Request->executeApi($title);

            $poster_path = $this->save($film_data["Poster"]);
            $new_film = film::createFromJson($film_data, $poster_path);
            return $new_film;

        } catch (Error $ex) {
            return response()->json([
                "error_title" => "Что то пошло не так",
                "error_message" => $ex->getMessage(),
            ], 500);
        }
    }

    protected function save($url)
    {
        $path = "./img/" . Str::random(32) . ".jpg";
        file_put_contents($path, file_get_contents($url));
        return $path;
    }
}
