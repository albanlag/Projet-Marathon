<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use Illuminate\Http\Request;
use Parsedown;

use Illuminate\Support\Facades\Route;
use SebastianBergmann\Type\TrueType;

class ChapitreController extends Controller
{

    public function show(int $id){
        $chapitre = Chapitre::find($id);
        $parsedown = new Parsedown();
        $reponses = [];
        foreach ($chapitre->suivants as $chap){
            $reponses[]=$chap->suite->reponse;
        }
        $texte = $parsedown->text($chapitre->texte);
        return view('chapitres.show', ['chapitre' => $chapitre,'texte'=>$texte,'reponses'=>$reponses])->with("success", 'Votre chapitre à bien été créer.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'histoire_id' => 'required|exists:histoires,id',
            'titre' => 'required|string',
            'titrecourt' => 'required|string',
            'media' => 'required|string',
            'question' => 'nullable|string',
            'premier' => 'nullable',
            'text' => 'required|string',
        ]);

        $chapitre = new Chapitre();
        $chapitre->histoire_id = $request->input('histoire_id');
        $chapitre->titre = $request->input('titre');
        $chapitre->titrecourt = $request->input('titrecourt');
        $chapitre->media = $request->input('media');
        $chapitre->question = $request->input('question');
        $chapitre->premier = $request->has('premier');
        $chapitre->texte = $request->input('text');
        $chapitre->save();

        return redirect()->route('histoires.encours', ['id' =>  $chapitre->histoire_id])->with('success', 'Chapitre ajouté avec succès');
    }

    public function lien(Request $request) {
        $request->validate([
            'histoire_id' => 'required|exists:histoires,id',
            'source' => 'required|exists:chapitres,id',
            'destination' => 'required|exists:chapitres,id',
            'reponse' => 'required|string',
        ]);

        $histoireId = $request->input('histoire_id');
        $chapitreSourceId = $request->input('source');
        $chapitreDestinationId = $request->input('destination');
        $reponse = $request->input('reponse');

        $chapitreSource = Chapitre::find($chapitreSourceId);
        $chapitreSource->suivants()->attach($chapitreDestinationId, ['reponse' => $reponse]);

        return redirect()->route('histoires.encours', ['id' => $histoireId])->with('success', 'liaison ajoutée avec succès');
    }

}
