<?php

namespace App\Http\Controllers;

use App\CoreApp\ApiRequest;
use App\film;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    const URL_SITE =
        "http://www.omdbapi.com/?apikey=c585f45d&t=";
    const COUNT_ELEM = 5;

    public function find($title, Request $request, ApiRequest $api_Request)
    {

        try {

            if (preg_match('/tt\d{7}/', $title)) {
                if ($find_filmDb_byID = film::checkFilmById($title)) {
                    return $find_filmDb_byID;
                } else {
                    $film_data = $api_Request->executeApi($title, true);
                    $new_film = film::create($film_data);
                    return $new_film;
                }
            }

            if ($find_filmDb = film::checkFilm($title)) {
                return $find_filmDb;
            }

            $film_data = $api_Request->executeApi($title);
            $new_film = film::create($film_data);
            return $new_film;

        } catch (Error $ex) {
            return response()->json([
                "error_title" => "Что то пошло не так",
                "error_message" => $ex->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        if ($request->p) {
            $start_page = $request->p * self::COUNT_ELEM - self::COUNT_ELEM;
            $end_page = $request->p * self::COUNT_ELEM;
            return film::all()->slice($start_page, $end_page);
        }

        return film::all();
    }

    public function show(film $film)
    {
        return $film;
    }

    public function delete(film $film)
    {
        $film->delete();
        return response()->json('', 200);
    }

    public function update(Request $request, film $film)
    {
        $film_edit_flag = $film->update($request->all());
        return $film_edit_flag ? $film : response()->json([
            'error_message' => 'Film not update',
            'error_title' => 'Мы не смогли обновить фильм'
        ], 500);
    }

    public function created(Request $request)
    {
        return film::create($request->all());
    }

    public function testImage(Request $request)
    {
        return $this->getImageColor($request->url, 1);
    }
}
