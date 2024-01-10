@extends("templates.app")

@section('content')
<section class="show_histoire">
@if($histoire)
    @if ($errors->any())
        <div>
            <strong>Il y a des erreurs dans le formulaire :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="show_histoire-tout">
    <div class="show_histoire-gauche">
            @if(str_contains($histoire->photo, 'http'))
                <img src="{{$histoire->photo}}" alt="Pas d'image">
            @else
                <img src="{{Storage::url($histoire->photo)}}" alt="Pas d'image">
            @endif
    </div>




    <div  class="show_histoire-droite">
        <div class="show_histoire-titre">
            <h2>{{$histoire->titre}}</h2>
            <p>{{$histoire->user->name}}</p>
        </div>

            <div class="show_histoire-genre">
                <form action="{{route('index')}}" method="get">
                <input type="hidden" name="cat" value="{{$histoire->genre->label}}">
                <input class="show_histoire-genre-bouton" type="submit" value="{{$histoire->genre->label}}">
                </form>
            </div>

            <div class="show_histoire-texte">
                <p>{!!$pitch!!}</p>
            </div>


            <p class="show_histoire-personnes"><strong>{{$nbFini}}</strong> personnes l'ont fini</p>

            <p class="show_histoire-personnes"><strong>{{$nbComment}}</strong> personnes ont commenter</p>
            
            <p class="show_histoire-personnes"><strong>{{$histoire->active}}</strong> sont entrain de lire cette histoire</p>

    


            @auth
                @if($histoire->user->id == auth()->user()->id)
                    @if($histoire->active == 0)
                        <a href="{{ route('histoires.encours', ['id'=>$histoire->id]) }}"><button>MODIFIER L'HISTOIRE</button></a>
                    @else
                        <a href="{{ route('histoire.activate', ['id' => $histoire->id]) }}"><button>METTRE PRIVEE L'HISTOIRE</button></a>
                    @endif
                @endif
            @endauth


            @if($premier_chapitre)
                <a href="{{ route('chapitres.show', $premier_chapitre) }}"><button class="show_histoire-bouton">Commencer l'Histoire</button></a>
            @endif
            </div>
            </div>
            <div class="show_histoire-commentaire">
            <h2>Commentaire(s)</h2>
            @auth
            <a href="{{Route('avis.create',$histoire->id)}}">Ajouter un commentaire</a>
            @endauth
            @if(!empty($histoire->avis))
                @foreach($histoire->avis->sortByDesc('created_at') as $comment)
                    
                    @if ($comment->created_at)
                        <p>il y a {{$comment->created_at->diffInDays()}} jours</p>
                    @else
                        <p>La date de création n'est pas disponible.</p>
                    @endif
                    <p>{{$comment->contenu}}</p>
                    @auth
                        @if($comment->user->id == auth()->user()->id)
                        <form method="post" action="{{ route('avis.delete', ['avis_id' => $comment->id]) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" name="delete" value="Supprimer">
                        </form>
                        @endif
                    @endauth
                    <hr>
                @endforeach
            @else
                <p>Pas de commentaires</p>
                @endif
                </div>
    
        </p>
        <!-- Faire en sorte que ce soit un lien cliquable, et non pas un bouton ! -->
    </div>
    </section>


@else
    <p>Pas d'histoire</p>
@endif

@endsection
