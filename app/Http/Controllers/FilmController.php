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

    public function find($title, Request $request, ApiRequest $api_Request)
    {

        try {
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

    // TODO Может вынести эту функции куда-то?

    protected function getImageColor($imageFile_URL, $numColors, $image_granularity = 5)
    {
        $image_granularity = max(1, abs((int)$image_granularity));
        $colors = array();
        $size = @getimagesize($imageFile_URL);
        if ($size === false) {
            user_error("Unable to get image size data");
            return false;
        }
        $img = imagecreatefromjpeg($imageFile_URL);
        if (!$img) {
            return ['000000'];
        }
        for ($x = 0; $x < $size[0]; $x += $image_granularity) {
            for ($y = 0; $y < $size[1]; $y += $image_granularity) {
                $thisColor = imagecolorat($img, $x, $y);
                $rgb = imagecolorsforindex($img, $thisColor);
                $red = round(round(($rgb['red'] / 0x33)) * 0x33);
                $green = round(round(($rgb['green'] / 0x33)) * 0x33);
                $blue = round(round(($rgb['blue'] / 0x33)) * 0x33);
                $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue);
                if (array_key_exists($thisRGB, $colors)) {
                    $colors[$thisRGB]++;
                } else {
                    $colors[$thisRGB] = 1;
                }
            }
        }
        arsort($colors);
        return array_slice(array_keys($colors), 0, $numColors);
    }
}
