@extends("templates.app")

@section('content')
<style>
.header{
    background-color: rgba(255,255,255,0.5);
    box-shadow: none;
    transition: background-color 0.25s ease-in;
}

.bg_blanc {
    box-shadow: 0 -1vh 3vh black;
    background-color: rgba(255,255,255,1);
    transition: background-color 0.25s ease-in;
}
</style>
    <div class="video_fond">
        <video muted autoplay>
            <source src="{{Vite::asset('resources/videos/video_fond_site.mp4')}}" type="video/mp4" />
            <p>Votre navigateur ne prend pas en charge les vidéos HTML5.</p>
        </video>
    </div>
    <div class="Top_tendances">
        <h1>Les tendances :</h1>
        <div class="Tendances">
        @if(!empty($tops))
        @foreach($tops as $top)
        <div class="Tendance">
            <a href="{{Route('histoire.show', $top['histoire']->id)}}">
                <h1 class="Titre_td">{{$top['histoire']->titre}}</h1>
                @if(str_contains($top['histoire']->photo, 'http'))
                    <div class="image_desc">
                        <img src="{{$top['histoire']->photo}}" alt="Pas d'image">
                        <span class="Desc_td">{{$top['histoire']->pitch}}</span>
                    </div>
                @else
                    <div class="image_desc">
                        <img src="{{Storage::url($top['histoire']->photo)}}" alt="Pas d'image">
                        <span class="Desc_td">{{$top['histoire']->pitch}}</span>
                    </div>
                @endif
                <h2 class="Genre_td">{{$top['histoire']->genre->label}}</h2>
                <h3 class="nombre_trmn"><i class='bx bx-check-circle'></i>{{$top['nb_terminees']}}</h3>
                <p class="nombre_lect"><i class='bx bxs-book'></i>{{$top['nb_lectures']}}</p>
                <a href="{{Route('user.personal', $top['histoire']->user->id)}}">
                    <p class="auteur_accueil">Créer par : {{$top['histoire']->user->name}}</p>
                </a>
            </a>
            <hr>
        </div>
        @endforeach
        @else
            <p>Aucune histoire</p>
        @endif
        </div>
        </div>
        <div class="cat_aleatoire">
        <h1>Une séléction aléatoire :</h1>
        <div class="Aleatoires">
        @if(!empty($aleatoires))
        @foreach($aleatoires as $aleatoire)
        <div class="Aleatoire">
            <a href="{{Route('histoire.show', $aleatoire->id)}}">
                <p>{{$aleatoire->titre}}</p>
                @if(str_contains($aleatoire->photo, 'http'))
                <div class="image_desc">
                    <img src="{{$aleatoire->photo}}" alt="Pas d'image">
                    <span class="Desc_td">{{$aleatoire->pitch}}</span>
                </div>
                @else
                <div class="image_desc">
                    <img src="{{Storage::url($aleatoire->photo)}}" alt="Pas d'image">
                    <span class="Desc_td">{{$aleatoire->pitch}}</span>
                </div>
                @endif
                <h2 class="Genre_td">{{$aleatoire->genre->label}}</h2>
            </a>
            <a href="{{Route('user.personal', $aleatoire->user->id)}}">
                <p>{{$aleatoire->user->name}}</p>
            </a>
            <hr>
        </div>
            @endforeach
            @else
                <p>Aucune histoire</p>
            @endif
        </div>
        </div>

        <div class="cat_redaction">
        <h1>Vous souhaitez filtré votre recherche ?</h1>
        @if(!empty($filters))
            <form action="{{route('index')}}" method="get">
                <select name="cat">
                    <option value="All" @if($cat == 'All') selected @endif>-- Tous les genres --</option>
                    @foreach($genres as $genre)
                        <option value="{{$genre}}" @if($cat == $genre) selected @endif>{{$genre}}</option>
                    @endforeach
                </select>
                <input type="submit" value="OK">
            </form>
            <div class="redactions">
            @foreach($filters as $filter)
            <div class="redaction">
                <a href="{{Route('histoire.show', $filter->id)}}">
                    @if(str_contains($filter->photo, 'http'))
                    <div class="image_desc">
                        <img src="{{$filter->photo}}" alt="Pas d'image">
                        <span class="Desc_td">{{$filter->pitch}}</span>
                    </div>
                    @else
                    <div class="image_desc">
                        <img src="{{Storage::url($filter->photo)}}" alt="Pas d'image">
                        <span class="Desc_td">{{$filter->pitch}}</span>
                    </div>
                    @endif
                    <p>{{$filter->titre}}</p>
                    <p>Genre : {{$filter->genre->label}}</p>
                    <a href="{{Route('user.personal', $filter->user->id)}}">
                    <p>{{$filter->user->name}}</p>
                </a>
                </a>
                <hr>
                </div>
            @endforeach
        @else
            <p>Aucune histoire</p>
        @endif
        </div>
        </div>



    <script>

 let nav = document.getElementById('menuBar');
 let burger = document.getElementById('menuBurger');
//var navTop = nav.offsetTop;

window.onscroll = function () { myScrollFunction() };

function myScrollFunction() {
    if (document.documentElement.scrollTop > 1){
        nav.classList.add('bg_blanc');
    }
    else{
        nav.classList.remove('bg_blanc')
    }
        
  //  var res = navTop - document.documentElement.scrollTop;
   /* if (res > 0) {
        nav.setAttribute('style', 'top:' + res + 'px');
    } else {
        nav.setAttribute('style', 'top:0px')
    }
    */

    //console.log("djmfqjm")
}

    </script>
@endsection