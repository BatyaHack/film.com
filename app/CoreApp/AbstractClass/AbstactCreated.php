<?php

namespace App\CoreApp\AbstractClass;


abstract class AbstractCreated
{

    protected $URL = "";
    protected $titleOrID = "";


    abstract public function getFilm($title);

    protected function executeApi($title)
    {
        $this->titleOrID = $this->toCorrectUrl($title) . '&plot=full';
        $default_settings = $this->setSettings();
        $ch = curl_init();
        curl_setopt_array($ch, $default_settings);
        $film_data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $film_data;
    }

    /**
     * Настройки по которым будет осуществлятся запрос к серверу
     * @param string $title
     * @param string $URL
     * @return array
     */
    protected function setSettings()
    {
        return array(
            CURLOPT_URL => $this->URL . $this->titleOrID, // куда идем
            CURLOPT_HEADER => 0, // заголовки
            CURLOPT_RETURNTRANSFER => TRUE, // вернуть контент, а не инфу удачно не удачно
            CURLOPT_TIMEOUT => 4 // время которое ждем
        );
    }

    /**
     * Делаем корректный URL. Если приходит "слово1 слово2", то получим "слово1+слово2"
     * @deprecated Скорее всего это преобразование отработает автоматичски
     * @param $title
     * @return string
     */
    protected function toCorrectUrl($title)
    {
        $correct_title = trim($title);
        $correct_title_array = explode(" ", $correct_title);
        return implode("+", $correct_title_array);
    }
}