<?php

namespace App\Gestion;
use Storage;
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

    ##crée un document dans Nuxeo dans l'espace indiqué : que ce soit file ou folder
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

      //print_r($out);

      //retourne l'uid du dossier/fichier créé
      return $out['uid'];

    }

    //creation d'un batch d'upload, revois le batchid
  public function createBatch()
  {
    //creation url du batch
    $url=$this->url."/upload/";

    //creation de la requete
    $reponse=\Guzzle::post($url,[
      'auth' => [ $this->user, $this->pass],
    ]);

    //récupère la réponse http contenant le batchid
    $out=$reponse->getBody();

    #decode le json en array
    $out=json_decode($out,true);

    print "Batchid : ";
    print_r($out);

    //retourne l'uid du dossier/fichier créé
    return $out['batchId']."dd";

  }

  //upload du fichier sur le serveur, sans affectation
  public function uploadFile($file,$filename,$batchid)
  {
    //creation url de l'upload
    $url=$this->url."/upload/".$batchid."/0";

    if(!Storage::disk('imports')->has($file))
    {

      return 0;
    }
    else {
    /*print  Storage::disk('imports')->url($file)."<br>";
    print 'good -> /USERS/phpinfo/laravel/nupload/imports/'.$file.'<br>';
    print system('pwd').'<br>';*/
    }

    $reponse=\Guzzle::post($url,[
      'auth' => [ $this->user, $this->pass],
      'headers'  => ['X-File-Name' => $filename],
      'multipart' => [
          [
              'name'     => 'image',
              //'contents' =>  fopen('/USERS/phpinfo/laravel/nupload/imports/'.$file,'r')  //  Storage::disk('imports')->url($file)
              'contents' =>  fopen('/USERS/phpinfo/laravel/nupload/imports/'.$file,'r')

          ]
        ]

    ]);
    print "<br><br>réponse upload<br>";
    print_r($reponse);

    #extrait le body de la reponse

    $out=$reponse->getBody();



    #print Storage::disk('imports')->get($file);

    #decode le json en array
    $out=json_decode($out,true);

    print_r($out);

    //retourne l'uid du dossier/fichier créé
    return $out;



  }





  //fonction relie le fichier uploadé à un document
  public function linkUploadedFile($documentid,$batchid)
  {
    //creation url du linkage
    $url=$this->url."/upload/$batchid";

    //creation de l'url ID du fichier
    $documentidurl=$this->url."/id/".$documentid;

    print "<br><br><br>docurl:".$documentidurl."<br>";
    print "batchid:".$batchid."<br>";
    $reponse=\Guzzle::get($documentidurl,
    [
      'auth' => [ $this->user, $this->pass],
      'headers'  => ['content-type' => 'application/json'],
      'body' =>json_encode(
          [
            'entity-type' => 'document',
            'properties' =>
                ['file:content' =>
                    [
                      'upload-batch' => $batchid ,
                      'upload-fileId' => 0
                    ]
                ]
          ])
    ]
    );





    #extrait le body de la reponse

    $out=$reponse->getBody();


    print "<br><br>réponse linkage<br>";

    #decode le json en array
    $out=json_decode($out,true);

    print_r($out);

    //retourne l'uid du dossier/fichier créé
    return $out['uid'];

  }

}
