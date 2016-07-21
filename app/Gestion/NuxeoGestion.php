<?php

namespace App\Gestion;

class NuxeoGestion
{

  #à l'instanciation récupère les paramètres
  public function __construct()
    {
      $this->url=env('NUXEOAPI_URL');
      $this->user=env('NUXEOAPI_USER');
      $this->pass=env('NUXEOAPI_pass');
    }


    #test de l'injection de dépandance
    public function test($message)
    {

        return "*depuis dependance* ".$message.$this->url;

    }

    #execution de la requete sur le serveur nuxeo
    public function request($urlparameters,$jsonParameters)
    {

      $this->reponse=\Guzzle::get($url.$urlparameters,$jsonParameters);
    }

    ##crée un répertoire dans Nuxeo dans l'espace indiqué.
    public function createFolder($place,$parameters)
    {
      
    }

}
