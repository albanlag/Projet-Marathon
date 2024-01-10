@extends("templates.app")

@section('content')
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

    <div class="image_et_btons">
        <h1>Édition de l'histoire : {{ $histoire->titre }}</h1>
        @if(str_contains($histoire->photo, 'http'))
            <img src="{{$histoire->photo}}" alt="Pas d'image">
        @else
            <img src="{{Storage::url($histoire->photo)}}" alt="Pas d'image">
        @endif
        <!-- Affichez les détails de l'histoire ici -->
        <a href="{{ route('histoire.activate', ['id' => $histoire->id]) }}"><button>ACTIVATE</button></a>
        <a href="{{Route('histoire.show', $histoire->id)}}"><button>TESTER</button></a>
</div>
        <div class="formulaires">
            <form action="{{ route('chapitres.store') }}" method="post">
                @csrf
                <h2>Ajouter un chapitre</h2>
                <input type="hidden" name="histoire_id" value="{{ $histoire->id }}">
                <label for="titre">Titre du chapitre</label>
                <input type="text" name="titre" id="titre" required>
                <label for="titre">Titre court  du chapitre</label>
                <input type="text" name="titrecourt" id="titrecourt" required>
                <label for="titre">Media</label>
                <input type="text" name="media" id="media" required>
                <label for="titre">Question</label>
                <input type="text" name="question" id="question">
                <label for="premier"><strong>Premier </strong></label>
                <input type="checkbox" id="premier" name="premier"/>
                <label for="text">Contenu du média</label>
                <textarea id="text" name="text" rows="4" cols="50"></textarea>

                <button type="submit">Ajouter Chapitre</button>
            </form>
        
      
          
          @if($histoire->chapitres->isNotEmpty())
              <form action="{{ route('chapitres.lien') }}" method="post">
                  @csrf
                  <h2>Liaison des chapitres</h2>
                  <input type="hidden" name="histoire_id" value="{{ $histoire->id }}">
                  <label for="titre">Source du chapitre :</label>
                  <select name="source">
                      @foreach($histoire->chapitres as $chapitre)
                          <option value="{{$chapitre->id}}" >{{$chapitre->id}} - {{$chapitre->titre}}</option>
                      @endforeach
                  </select>
                  <label for="titre">Destination du chapitre :</label>
                  <select name="destination">
                      @foreach($histoire->chapitres as $chapitre)
                          <option value="{{$chapitre->id}}" >{{$chapitre->id}} - {{$chapitre->titre}}</option>
                      @endforeach
                  </select>
                  <label for="reponse">Réponse:</label>
                  <input type="text" name="reponse" id="reponse" required/>
                  <button type="submit">Ajouter Liaison</button>
              </form>
          @else
              <p>Aucun chapitre</p>
          @endif
          </div>
          <div class="Form2">
            <div class="l1">
            @if(!empty($histoire->chapitres))
                <h2>Chapitres de l'histoire : </h2>
                <hr/>
                @foreach($histoire->chapitres as $chapitre)
                    <p>ID : {{$chapitre->id}}</p>
                    <p>Titre cours : {{$chapitre->titrecourt}}</p>
                    <p>Question : {{$chapitre->question}}</p>
                    <hr/>
                @endforeach
            @else
                <h1>Aucun chapitre.</h1>
            @endif
            </div>
            <div class="l2">
          <h2>Liste des liaisons : </h2>
          @if($histoire->chapitres->isNotEmpty())
              @foreach($histoire->chapitres as $chapitre)
                  @foreach($chapitre->suivants as $next)
                      <p>Source : {{$chapitre->id}} - {{$chapitre->titre}}</p>
                      <p>Destination : {{$next->id}} - {{$next->titre}}</p>
                      <p>Réponse : {{$next->suite->reponse}}</p>
                  @endforeach
              @endforeach
          @else
              <p>Aucun lien</p>
          @endif
          </div>
          </div>
      </div>

    </div>


@endsection
