<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Formulaire;
use App\User;
use Auth;
class FormulaireController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');


  }


    /**
     * Display a listing of the resource. =tous les formulaires disponibles
     *
     * @return \Illuminate\Http\Response
     */
    public function indexall()
    {

        $forms = Formulaire::orderBy('created_at','asc')->get();

        return view('formulaire_list_all',[
          'formulaires' => $forms
        ])->withNote('Liste de tous les formulaires');
    }

    //tous les formulaires de l'utilisateur

    public function index()
    {

        
        $forms = Formulaire::with('user')
                ->whereHas('user',function($q)
                        		{
                        		  $q->where('users.id', Auth::user()->id );
                        		}
                          )
                ->orderBy('created_at','asc')
                ->get();

        return view('formulaire_list',[
          'formulaires' => $forms
        ])->withNote('Mes formulaires');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
