<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Histoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Avis::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($histoire_id)
    {
        return view('avis.create',['histoire_id'=>$histoire_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'contenu'=> "required",
            'histoire_id'=>"required",
        ]);
        $avi = new Avis();
        $avi->contenu = $request->contenu;
        $avi->user_id = Auth::id();
        $avi->histoire_id = $request->histoire_id;
        $avi->save();

        return redirect()->route('histoire.show',$avi->histoire_id)->with('success', "Votre commentaire à été ajouté");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $avis = Avis::find($id);
        if ($request->delete == "Supprimer" && Auth::check() && auth()->user()->id == $avis->user_id) {
            $avis->delete();
        }

        return redirect()->back()->with('success', 'Commentaire supprimé.');
    }
}
