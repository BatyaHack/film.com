<?php

namespace App\Http\Controllers;

use App\CoreApp\ApiRequestID;
use App\CoreApp\ApiRequestTitle;
use App\film;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    const URL_SITE =
        "http://www.omdbapi.com/?apikey=c585f45d&t=";
    const COUNT_ELEM_ANSWER = 10;

    /**
     * Ищем фильм или по заголовку или по ID фильма (который вытягиваем по регулярке)
     * Сначала проверяем свою бд, если фльм есть, то возвращаем его
     * Если фильм нет, то идем на imdpAPI и потом еще возвращаем
     *
     * Стоит ли разбить ApiRequest не два класса (унаследованные от одного родительсвого)
     * Но тогда придеться создавать два класса, а не одим. Хммммм
     * Не жирный ли контроллер?
     *
     * Переписал на классы, но все же может было лучше все в одном?!
     *
     * @param $title
     * @param Request $request
     * @param ApiRequestTitle $api_Request
     * @param ApiRequestID $api_RequestID
     * @return ApiRequestID|ApiRequestTitle
     */
    public function find($title, Request $request, ApiRequestTitle $api_Request, ApiRequestID $api_RequestID)
    {

        try {

            if (preg_match('/tt\d{7}/', $title)) {
                $film = $api_RequestID->getFilm($title);
                return response()->json($film);
            }

            $film = $api_Request->getFilm($title);
            return response()->json($film);

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
            $count_page = ceil(film::count() / self::COUNT_ELEM_ANSWER);
            $start_page = $request->p * self::COUNT_ELEM_ANSWER - self::COUNT_ELEM_ANSWER;
            return response()->json([
                'filmList' => film::all()->slice($start_page, self::COUNT_ELEM_ANSWER),
                'countPage' => $count_page,
            ]);
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
