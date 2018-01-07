<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class film extends Model
{
    protected $guarded = []; // разрешим масовое заполнение

    // правильно ли распологать этот метод в модели???
    public static function createFromJson($dataJson) {
        film::create([
            "title" => $dataJson["Title"],
            "year" => $dataJson["Year"],
//            "title" => $dataJson["Title"],
//            "title" => $dataJson["Title"],
//            "title" => $dataJson["Title"],
//            "title" => $dataJson["Title"],
//            "title" => $dataJson["Title"],
//            "title" => $dataJson["Title"],
//            "title" => $dataJson["Title"],
        ]);
    }

    public static function checkFilm($title) {
        return $film_name = film::where('title', $title);
    }
}
