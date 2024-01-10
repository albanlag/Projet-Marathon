<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function index(){
        $equipe= [
            'nomEquipe'=>"Les paquetas",
            'logo'=>"logo.jpg",
            'slogan'=>"Ici ça code",
            'localisation'=>"13E",
            'membres'=> [
                [ 'nom'=>"Lagragui",'prenom'=>"Alban", 'image'=>"surfer.jpg", 'fonctions'=>["validateur","développeur"] ],
                [ 'nom'=>"Damlencourt",'prenom'=>"Valentin", 'image'=>"surfer.jpg", 'fonctions'=>["développeur"] ],
                [ 'nom'=>"Halipré",'prenom'=>"Aude", 'image'=>"surfer.jpg", 'fonctions'=>["développeuse"] ],
                [ 'nom'=>"Royer",'prenom'=>"Thomas", 'image'=>"surfer.jpg", 'fonctions'=>["développeur"] ],
                [ 'nom'=>"Beaussart",'prenom'=>"Quentin", 'image'=>"surfer.jpg", 'fonctions'=>["concepteur"] ],
                [ 'nom'=>"Fourdin",'prenom'=>"Gaël", 'image'=>"surfer.jpg", 'fonctions'=>["concepteur"] ],
                [ 'nom'=>"Legru",'prenom'=>"Maxime", 'image'=>"surfer.jpg", 'fonctions'=>["concepteur"] ],
                [ 'nom'=>"Mirbelle",'prenom'=>"Guillem", 'image'=>"surfer.jpg", 'fonctions'=>["concepteur"] ],
                [ 'nom'=>"Picquet",'prenom'=>"Sébastien", 'image'=>"surfer.jpg", 'fonctions'=>["concepteur"] ],
            ],
            'autres'=>"Autre chose",
        ];
        return view('equipes.index', ['equipe' => $equipe]);
    }
}