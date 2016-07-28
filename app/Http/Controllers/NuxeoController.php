<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Gestion\NuxeoGestion;

class NuxeoController extends Controller
{

  //Tableau d'import de Nuxeo
  public $nuxeotab;
  //localisation du repertoire d'import
  public   $nuxeoimportfolder="/USERS/phpinfo/laravel/nupload/imports/";

  #retourne la prop d'un objet sous forme de texte et l'inclut
  public function getXmlProp($dsobj,$prop,$ds_id)
  {
    $value=$dsobj->props->xpath('prop[@name="'.$prop.'"]');

    if(!empty($value))
    {
      $value=(string)$value[0];
      $this->nuxeotab[$ds_id][$prop]=$value;
    }
    //affectation au tableau




    return $value;
  }

  //fonction de creation d'un document variant_date_to_timestamp
  public function import($import)
  {
      //parse le xml
      $this->parse($import,false);



      $note="Parse OK ".count($this->nuxeotab)." objets";

      $nuxeo=new NuxeoGestion;

      //crée un folder
      //$idfolder=$nuxeo->createDocument("1f992202-3b57-4e14-a649-f370b15c0e55","Folder","laravel folder".date("Y-m-d H:i:s"));

      $idfolder="1f992202-3b57-4e14-a649-f370b15c0e55";
      //crée le document
      $id=$nuxeo->createDocument($idfolder,"File","laravel ".date("Y-m-d H:i:s"));
      //crée un batch e trécupère son id
      $batchid=$nuxeo->createbatch();
      //on upload le fichier
      $upload=$nuxeo->uploadFile('patate.jpg',"patate.jpg",$batchid);

      print_r($upload);

      $nuxeo->linkUploadedFile($id,$batchid);

      return view('generic_view')->withNote('Message '.$note." ".$id)->withDatas([]);

  }


#parse un repertoire pour le mettre dans un tableau
  public function parse($import,$display=True)
  {
    //DSI
    //$xmlfile="/USERS/phpinfo/laravel/nupload/imports/Collection-15616/Collection-15616.xml";
    //FAYOL
    //$xmlfile="/USERS/phpinfo/laravel/nupload/imports/Collection-5745/Collection-5745.xml";
    //$xml = simplexml_load_file($xmlfile);

    //reconstruit le chemin de telle sorte
    $pathtoxml="/".$import."/".$import.".xml";

    $note="";

    //recupere le contenu du fichier
    $xmlcontent = Storage::disk('imports')->get($pathtoxml);

    //convertit le texte xml en objet simplexml_load_file
    $xml = simplexml_load_string($xmlcontent);

    //print $import.$xmlcontent;

    $this->nuxeotab="";

    #tableau contenant les données nuxeo


    //$file=fopen($xmlfile);

    foreach ($xml as $id => $dsobject) {
      //print_r($dsobject);


      //Type de document
      $ds_type=(string)$dsobject->attributes()->classname;


      //Nom Docushare du document
      $ds_id=(string)$dsobject->attributes()->handle;


      //description du document
      $this->getXmlProp($dsobject,"description",$ds_id);



      //Libellé du document/Collection
      $this->getXmlProp($dsobject,"title",$ds_id);


      //nom original du fichier
      $this->getXmlProp($dsobject,"filename",$ds_id);

      //résumé du fichier ( keywords)
      $this->getXmlProp($dsobject,"keywords",$ds_id);

      //résumé du fichier ( keywords)
      $this->getXmlProp($dsobject,"original_file_name",$ds_id);

      //Collections contenant le fichier/la collection
      $ds_father=(string)$dsobject->sourcelinks->containment;


      //Listre des contenus de la collection
      $ds_childs="";
      $ds_child="";
      $ds_childs=$dsobject->destinationlinks->containment;

      foreach ($ds_childs as $child) {
        $ds_child[]=(string)$child;
      }


      //Le propriétaire de l'objet
      $ds_owner=(string)$dsobject->destinationlinks->owner;



      $this->nuxeotab[$ds_id]['type']=$ds_type;

      $this->nuxeotab[$ds_id]['father']=$ds_father;
      $this->nuxeotab[$ds_id]['childs']=$ds_child;
      $this->nuxeotab[$ds_id]['owner']=$ds_owner;





if($ds_id=="Collection-16730")
{
      /*print_r($dsobject);
      print_r($this->nuxeotab[$ds_id]);*/
}


    #  $this->nuxeotab[$dsobject->attributes()['handle'][0]]=1;
      #$this->nuxeotab[$ds_id]['type']=1;


      #print "$id *****<br>";
    }


    #print_r($xml);
    if($display==true)
    print_r($this->nuxeotab);

    #return view('generic_view')->withNote('Test de connexion à '.$xml.$xmlfile)->withDatas(['tab1','tab2']);
    return view('generic_view')->withNote('Message '.$note)->withDatas([]);
  }

  //créée la liste des collections importables
  public function importlist()
  {
    $nuxeo=new NuxeoGestion;



    //recupere les dossiers contenus dans storage
    $liste = Storage::disk('imports')->directories('/');

    Storage::disk('imports')->prepend('storagelog.log', time().'lecture du contenu');





    return view('import_list_all')->withNote('Liste des imports possibles')->withList($liste);


  }


//test : creation d'un repertoire
  public function test()
  {
    $nuxeo=new NuxeoGestion;

    $note=$nuxeo->test('*depuis controller*');

    return view('generic_view')->withNote('Test de connexion à '.$note)->withDatas(['tab1','tab2']);
  }

  //Retourne les informations d'un utilisateur
  public function getuser($user)
  {

  }


  /*
    //classe de base
    public function test(){
      //connection de base jeedom pour test
      $url="http://globiboulga.no-ip.org/core/api/jeeApi.php?9b3m3nh73wqsjtg47pxi";
      //recupere la temperaure du salon
      $url="http://globiboulga.no-ip.org/core/api/jeeApi.php?api=9b3m3nh73wqsjtg47pxi&type=cmd&id=620";

      $url="https://ged.mines-telecom.fr/nuxeo/site/api/v1/user/gruel@emse.Fr";

      //authentification du user de l'API Nuxeo et requete
      $reponse=\Guzzle::get($url,[
        'auth' => [ 'api', 'api'],
      ]);
      #extrait le body de la reponse
      $out=$reponse->getBody();



      #decode le json en array
      $out=json_decode($out,true);




      $datas=$out['properties']['groups'];

print_r($datas);
      return view('generic_view',[
        'datas' => $datas
      ])->withNote('Test de connexion à '.$url);

      /*
      return view('generic_view')->withNote('Test de connexion à '.$url)->withDatas(compact('datas'));
      */
      /*
    }

    */
}
