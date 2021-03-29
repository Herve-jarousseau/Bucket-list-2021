<?php


namespace App\Services;


use phpDocumentor\Reflection\Types\Integer;

class Censurator
{

    private $badWords = array('petitmots', 'grosmots', 'petitmot', 'grosmot', 'beau', 'belle');

    public function purify(string $text): string
    {
        $newText = $text;
        for ($i = 0 ; $i < count($this->badWords) ; $i++) {
            $newText = str_ireplace( $this->badWords[$i], str_repeat( "*", strlen($this->badWords[$i])), $newText);
        }
        return $newText;
    }



}