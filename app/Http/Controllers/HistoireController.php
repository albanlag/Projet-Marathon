<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use App\Models\Histoire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Parsedown;

class HistoireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cat = $request->input('cat', null);
        $actives = $request->input('active', 1);
        $value = $request->cookie('cat', null);

        if (!isset($cat)) {
            if (!isset($value)) {
                $histoires = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where('histoires.active', $actives)
                    ->get();

                $cat = 'All';
                Cookie::expire('cat');
            } else {
                $histoires = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where('histoires.active', $actives)
                    ->get();

                $cat = $value;
                Cookie::queue('cat', $cat, 10);
            }
        } else {
            if ($cat == 'All') {
                $histoires = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where('histoires.active', $actives)
                    ->get();

                Cookie::expire('cat');
            } else {
                $histoires = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where("genres.label", $cat)
                    ->where('histoires.active', $actives)
                    ->get();

                Cookie::queue('cat', $cat, 10);
            }
        }

        $genres = Genre::distinct('label')->pluck('label');
        return view('histoires.index',['histoires'=>$histoires,'cat'=>$cat,'genres'=>$genres, 'active'=>$actives]);
    }

    public function main(Request $request)
    {

        $cat = $request->input('cat', null);
        $value = $request->cookie('cat', null);

        if (!isset($cat)) {
            if (!isset($value)) {
                $histoires_filtrer = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where('histoires.active', 1)
                    ->limit(4)
                    ->get();

                $cat = 'All';
                Cookie::expire('cat');
            } else {
                $histoires_filtrer = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where('histoires.active', 1)
                    ->limit(4)
                    ->get();

                $cat = $value;
                Cookie::queue('cat', $cat, 10);
            }
        } else {
            if ($cat == 'All') {
                $histoires_filtrer = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where('histoires.active', 1)
                    ->limit(4)
                    ->get();

                Cookie::expire('cat');
            } else {
                $histoires_filtrer = Histoire::select("histoires.*","label","name")
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->where('histoires.active', 1)
                    ->where("genres.label", $cat)
                    ->limit(4)
                    ->get();

                Cookie::queue('cat', $cat, 10);
            }
        }

        $histoire_aleatoire = Histoire::select("histoires.*")
            ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
            ->leftJoin("users", "histoires.user_id", "=", "users.id")
            ->where('histoires.active', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();


        $q = DB::getPdo()->prepare("
            SELECT 
                histoire_id as id,
                count(*) as nb,
                (SELECT SUM(nombre) FROM terminees WHERE terminees.histoire_id = t.histoire_id) as nb_lecture
            FROM terminees t
            GROUP BY histoire_id
            ORDER BY nb_lecture DESC, count(*) DESC limit 4
        ");

        $q->execute();
        $tmp = $q->fetchAll(DB::getPdo()::FETCH_OBJ);
        $histoire_tendance = [];
        foreach($tmp as $o) {
            $histoire_tendance[] = ["histoire" => Histoire::find($o->id), "nb_terminees" => $o->nb, 'nb_lectures' => $o->nb_lecture];
        }


        $genres = Genre::distinct('label')->pluck('label');
        return view('welcome',['filters'=>$histoires_filtrer, 'aleatoires' => $histoire_aleatoire, 'tops' => $histoire_tendance,'cat'=>$cat,'genres'=>$genres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        $users = User::all();

        return view('histoires.create', compact('genres', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'titre' => 'required|string',
            'pitch' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'image_histoire' => 'required|url',
        ]);

        $histoire = new Histoire();
        $histoire->titre = $request->input('titre');
        $histoire->pitch = $request->input('pitch');
        $histoire->user_id = Auth::id();
        $histoire->genre_id = $request->input('genre_id');
        $histoire->photo = $request->input('image_histoire');
        $histoire->active = 0;
        $histoire->save();


        return redirect()->route('histoires.encours', ['id'=>$histoire->id])->with('success', 'Histoire créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $histoire = Histoire::find($id);
        $parsedown = new Parsedown();
        if(!$histoire)
            return view('errors.404');

        $premier_chapitre = $histoire->chapitres->where('premier', 1)->first();
        $nbFini = $histoire->terminees->count();
        $nbComment = $histoire->avis->count();
        $pitch = $parsedown->text($histoire->pitch);
        return view('histoires.show',['histoire'=>$histoire,'nbFini'=>$nbFini, 'nbComment'=>$nbComment, 'premier_chapitre' => $premier_chapitre,'pitch'=>$pitch]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $histoire = Histoire::find($id);
        if(!$histoire || $histoire->active == 1)
            return view('errors.404');
        $premier_chapitre = $histoire->chapitres->where('premier', 1)->first();
        $nbFini = $histoire->terminees->count();
        $nbComment = $histoire->avis->count();
        return view('histoires.encours', ['histoire' => $histoire, 'nbFini' => $nbFini, 'nbComment' => $nbComment, 'premier_chapitre' => $premier_chapitre]);
    }

    public function activate($id)
    {
        $histoire = Histoire::find($id);

        if (!$histoire) {
            return redirect()->back()->with('error', "L'histoire n'a pas été trouvée.");
        }

        if($histoire->active == 0)
            $histoire->active = 1;
        else
            $histoire->active = 0;
        $histoire->save();

        return redirect()->route('histoire.show',['id' => $id]);
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
    public function destroy(string $id)
    {
        //
    }

}
