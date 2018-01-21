<?php

namespace App\CoreApp;

class ApiRequest
{
    private $title;
    private $URL_SITE =
        "http://www.omdbapi.com/?apikey=c585f45d&";


    public function __construct()
    {

    }

    public function executeApi($title, $id = false) {
        $title = $this->toCorrectUrl($title);

        $this->URL_SITE = $id ? $this->URL_SITE . "i=" : $this->URL_SITE . "t=";

        $default_settings = $this->setSettings($title,  $this->URL_SITE);
        $ch = curl_init();
        curl_setopt_array($ch, $default_settings);
        $film_data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $film_data;
    }

    private function setSettings($title, $URL) {
        return array(
            CURLOPT_URL => $URL . $title, // куда идем
            CURLOPT_HEADER => 0, // заголовки
            CURLOPT_RETURNTRANSFER => TRUE, // вернуть контент, а не инфу удачно не удачно
            CURLOPT_TIMEOUT => 4 // время которое ждем
        );
    }

    private function toCorrectUrl($title)
    {
        $correct_title = trim($title);
        $correct_title_array = explode(" ", $correct_title);
        return implode("+", $correct_title_array);
    }

}