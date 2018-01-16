<?php

namespace App;

use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class film extends Model
{
    protected $guarded = []; // разрешим масовое заполнение

    public static function checkFilm($title)
    {
        return $film_name = film::where('title', $title)->first();
    }
    public static function boot() {
        self::creating(function ($film) {

            preg_match("/\d+/", $film->attributes["Runtime"], $matches);

            $film->attributes = array_change_key_case($film->attributes);

            $film->attributes["released"] = date("Y-m-d H:i:s", strtotime($film->attributes["released"] ?? null));
            $film->attributes["runtime"] = (integer)$matches[0] ?? null;
            $film->attributes["other_rating"] = json_encode($film->attributes["ratings"] ?? null);
            $film->attributes["path_to_poster"] = self::saveImageToLocal($film->attributes["poster"] ?? "./img/5TA3fnVzkuLsYY6A9gR7SUPM2lUniBZQ.jpg");
            $film->attributes["imdb_rating"] = $film->attributes["imdbrating"] ?? null;
            return true;
        });
    }

    private static function checkIndex($array, $index)
    {
        return $array[$index] ?? null;
    }
    private static function saveImageToLocal($url)
    {
        $path = "./img/" . Str::random(32) . ".jpg";
        file_put_contents($path, file_get_contents($url));
        return $path;
    }
}
