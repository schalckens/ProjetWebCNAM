<?php

namespace Controler;
use Model\MovieModel;

class MovieControler
{
    private $movieModel;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
    }
}
?>