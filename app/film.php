<?php

namespace App;

use ErrorException;
use Illuminate\Database\Eloquent\Model;

class film extends Model
{
    protected $guarded = []; // разрешим масовое заполнение

    // правильно ли распологать этот метод в модели???
    public static function createFromJson($dataJson, $poster_path)
    {

        preg_match("/\d+/", $dataJson["Runtime"], $matches);

        return film::create([
            "title" => self::checkIndex($dataJson, "Title"),
            "year" => (integer)self::checkIndex($dataJson, "Year"),
            "rated" => self::checkIndex($dataJson, "Rated"),
            "released" => date("Y-m-d H:i:s", strtotime(self::checkIndex($dataJson, "Released"))),
            "runtime" => (integer)$matches[0],
            "director" => self::checkIndex($dataJson, "Director"),
            "awards" => self::checkIndex($dataJson, "Awards"),
            "other_rating" => json_encode(self::checkIndex($dataJson, "Ratings")),
            "path_to_poster" => $poster_path,
            "imdb_rating" => (double)self::checkIndex($dataJson, "imdbRating"),
        ]);
    }

    private static function checkIndex($array, $index)
    {
        return $array[$index] ?? null;
    }

    public static function checkFilm($title)
    {
        return $film_name = film::where('title', $title)->first();
    }
}
