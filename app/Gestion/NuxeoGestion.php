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

    /*print "Batchid : ";
    print_r($out);*/

    //retourne l'uid du dossier/fichier créé
    return $out['batchId'];

  }

  //upload du fichier sur le serveur, sans affectation
  public function uploadFile($file,$filename,$batchid)
  {
    //creation url de l'upload
    $url=$this->url."/upload/".$batchid."/0";

    if(!Storage::disk('imports')->has($file))
    {
      print "$file introuvable ****";
      return 0;
    }
    else {

    }


    //$body=fopen('/USERS/phpinfo/laravel/nupload/imports/'.$file,'r');
    $body=Storage::disk('imports')->get($file);

    //requete d'upload du fichier
    $reponse=\Guzzle::post($url,[
      'auth' => [ $this->user, $this->pass],
      'headers'  => ['X-File-Name' => $filename],
      'body' => $body
    ]);

    #extrait le body de la reponse

    $out=$reponse->getBody();
    #$out=$reponse->send();



    #print Storage::disk('imports')->get($file);

    #decode le json en array
    $out=json_decode($out,true);

    print_r($out);

    //retourne l'uid du dossier/fichier créé
    return $out;



  }
//crée un document complet , upload le fichier dans le contenaeur spécifié
  public function createDocumentWithFile($nuxeocontainer="1f992202-3b57-4e14-a649-f370b15c0e55",$file,$filename,$metadata="")
  {



    //crée le document
    $id=$this->createDocument($nuxeocontainer,'File',$filename);
    //crée un batch e trécupère son id
    $batchid=$this->createbatch();
    //on upload le fichier
    $upload=$this->uploadFile($file,$filename,$batchid);

    $this->linkUploadedFile($id,$batchid);

    //renvoi de l'id du document créé
    return $id;
  }





  //fonction relie le fichier uploadé à un document
  public function linkUploadedFile($documentid,$batchid)
  {
    //creation url du linkage
    $url=$this->url."/upload/$batchid";

    //creation de l'url ID du fichier
    $documentidurl=$this->url."/id/".$documentid;

    $reponse=\Guzzle::put($documentidurl,
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
                      'upload-fileId' => "0"
                    ]
                ]
          ])
    ]
    );





    #extrait le body de la reponse

    $out=$reponse->getBody();


    /*print "<br><br>réponse linkage<br>";*/

    #decode le json en array
    $out=json_decode($out,true);

    /*print_r($out);*/

    //retourne l'uid du dossier/fichier créé
    return $out['uid'];

  }


  //Creation de la descendance ( arborescence descendante du document)

  public function createChilds($nuxeo_id,$ds_id,$nuxeotab,$nuxeoroot)
  {
    print $nuxeo_id." -> ".$ds_id."<br>";
    print_r($nuxeotab);
    print_r($nuxeotab[$ds_id]['childs']);

    if(!isset($nuxeotab[$ds_id]['childs']))
    {
      print "rien!!!!";
      return 0;
    }

      foreach ($nuxeotab[$ds_id]['childs'] as $id_child => $child) {
        print "$ds_id -->Child ".$child."<br>";

        //Si c'est un répertoire
        if($nuxeotab[$child]['type']=='Collection')
        {
          $id=$this->createDocument($nuxeo_id,'Folder',$nuxeotab[$child]['title']);
          print "<br>****child****<br>";
          print_r($child);
          print "ùùùùù";
          //si le dossier à des childs
          $ichilds=count($nuxeotab[$child]['childs']);
          print $ichilds." enfants pour $child<br><br>";
          print_r($nuxeotab[$child]['childs']);

          $this->createChilds($id,$child,$nuxeotab,$nuxeoroot);
        }

        //Si c'est un fichier
        if($nuxeotab[$child]['type']=='Document')
        {

          $pathtodoc="".$nuxeoroot."/documents/r_".$child."_0";

          print $pathtodoc."path";

          $id=$this->createDocumentWithFile($nuxeo_id,$pathtodoc,$nuxeotab[$child]['title']);



        }

      }

  }

}
