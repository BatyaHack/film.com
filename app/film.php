<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class film extends Model
{
    protected $guarded = []; // разрешим масовое заполнение

    // правильно ли распологать этот метод в модели???
    public static function createFromJson($dataJson) {

        preg_match("/\d+/", $dataJson["Runtime"], $matches);

        film::create([
            "title" => $dataJson["Title"],
            "year" => (integer)$dataJson["Year"],
            "rated" => $dataJson["Rated"],
            "released" => date("Y-m-d H:i:s", strtotime($dataJson["Released"])),
            "runtime" => (integer)$matches[0],
            "director" => $dataJson["Director"],
            "awards" => $dataJson["Awards"],
            "other_rating" => json_encode($dataJson["Ratings"]),
            "path_to_poster" => "",
            "imdb_rating" => (double)$dataJson["imdbRating"],
            // "other_rating" => $dataJson["Ratings"]
        ]);
    }

    public static function checkFilm($title) {
        return $film_name = film::where('title', $title)->first();
    }
}
