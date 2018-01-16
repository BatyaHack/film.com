<?php

namespace App;

use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class film extends Model
{
    protected $fillable = [
        'Title',
        'Year',
        'Rated',
        'Released',
        'Runtime',
        'Director',
        'Awards',
        'Poster',
        'imdbRating',
        'Ratings'];

    public static function checkFilm($title)
    {
        return $film_name = film::where("title", $title)->first();
    }
    public static function boot() {
        self::creating(function ($film) {
            $film->attributes = array_change_key_case($film->attributes);

//            dd($film);

            // делаем в тупую. потому что анонимнацая функция не видит нужный контекст

            if(!array_search("released", $film->attributes)) {
                $film->attributes["released"] = null;
            } else {
                $film->attributes["released"] = date("Y-m-d H:i:s", strtotime($film->attributes["released"]));
            }

            if(!array_search("runtime", $film->attributes)) {
                $film->attributes["runtime"] = null;
            } else {
                preg_match("/\d+/", $film->attributes["runtime"], $matches);
                $film->attributes["runtime"] = (integer)$matches[0];
            }

            if(!array_search("ratings", $film->attributes)) {
                $film->attributes["ratings"] = null;
            } else {
                $film->attributes["ratings"] = json_encode($film->attributes["ratings"]);
            }

            $film->attributes["poster"] = self::saveImageToLocal($film->attributes["poster"] ?? "./img/5TA3fnVzkuLsYY6A9gR7SUPM2lUniBZQ.jpg");
            return true;
        });
    }


    private static function checkNull($value) {

    }

    private static function saveImageToLocal($url)
    {
        $path = "./img/" . Str::random(32) . ".jpg";
        file_put_contents($path, file_get_contents($url));
        return $path;
    }
}
