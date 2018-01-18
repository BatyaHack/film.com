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
        'Ratings',
        'imdbID',
        'poster_color'];

    public static function checkFilm($title)
    {
        return $film_name = film::where("title", $title)->first();
    }
    public static function boot() {
        self::creating(function ($film) {
            $film->attributes = array_change_key_case($film->attributes);

            if(array_key_exists("released", ($film->attributes))) {
                $film->attributes["released"] = date("Y-m-d H:i:s", strtotime($film->attributes["released"]));
            } else {
                $film->attributes["released"] = null;
            }

            if(array_key_exists("runtime", ($film->attributes))) {
                preg_match("/\d+/", $film->attributes["runtime"], $matches);
                $film->attributes["runtime"] = (integer)$matches[0];
            } else {
                $film->attributes["runtime"] = null;
            }

            if(array_key_exists("ratings", ($film->attributes))) {
                $film->attributes["ratings"] = json_encode($film->attributes["ratings"]);
            } else {
                $film->attributes["ratings"] = null;
            }

            $film->attributes["poster_color"] = self::getImageColor(($film->attributes["poster"] ?? "./img/5TA3fnVzkuLsYY6A9gR7SUPM2lUniBZQ.jpg"), 1)[0];

            $film->attributes["poster"] = self::saveImageToLocal($film->attributes["poster"] ?? "./img/5TA3fnVzkuLsYY6A9gR7SUPM2lUniBZQ.jpg");
            return true;
        });
    }

    private static function saveImageToLocal($url)
    {
        $file_name = Str::random(32);
        $path = "./img/" . $file_name . ".jpg";
        file_put_contents($path, file_get_contents($url));
        return $file_name . ".jpg";
    }

    private static function getImageColor($imageFile_URL, $numColors, $image_granularity = 5)
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
