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
    const COUNT_ELEM = 10;

    // TODO не опасно ли доверять пользователю отпавку title? Или стоит как то его обработать
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

    // TODO Может вынести эту функцию куда-то?
    protected function save($url)
    {
        $path = "./img/" . Str::random(32) . ".jpg";
        file_put_contents($path, file_get_contents($url));
        return $path;
    }
}
