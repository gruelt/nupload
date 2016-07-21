<?php

namespace App\Gestion;

class NuxeoGestion
{

  #à l'instanciation récupère les paramètres
  public function __construct()
    {
      $this->url=env('NUXEOAPI_URL');
      $this->user=env('NUXEOAPI_USER');
      $this->pass=env('NUXEOAPI_PASS');
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
    public function createDocument($place="1f992202-3b57-4e14-a649-f370b15c0e55",$type="File",$name,$parameters="") //place = id du conteneur , $type = File/Folder
    {

      $url=$this->url."/id/".$place;
      $reponse=\Guzzle::post($url,[
        'auth' => [ $this->user, $this->pass],
        'headers'  => ['content-type' => 'application/json'],
        'body' =>json_encode(
            ['entity-type' => 'document',
            'name' => 'mondocument',
            'type' => $type,
            'properties' =>
                  ['dc:title' => $name]])
      ]);





      #extrait le body de la reponse

      $out=$reponse->getBody();



      #decode le json en array
      $out=json_decode($out,true);

      print_r($out);

      //retourne l'uid du dossier créé
      return $out['uid'];

    }

}
