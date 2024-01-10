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
    @if($chapitre)
        <div>
            <h1>{{$chapitre->titre}}</h1>
            <h2>{{$chapitre->titrecourt}}</h2>
            <img src="{{ $chapitre->media }}" alt="Cette image n'est pas disponible..." width="25%" height="10%">

            @if($chapitre->question)
                <p>{{$chapitre->question}}</p>
                @foreach($reponses as $reponse)
                    @php
                        $chapitreSuivantId = $chapitre->suivants->where('suite.reponse', $reponse)->pluck('suite.chapitre_destination_id')->first();
                    @endphp
                    <li><a href="{{route('chapitres.show', ['id' => $chapitreSuivantId])}}" > {{$reponse}} </a ></li>
                @endforeach
            @else
                <p>C'était le dernier chapitre. C'est, par conséquent, la fin de l'histoire !</p>
                <p><a href="{{ route('histoire.show', ['id' => $chapitre->histoire_id]) }}">Revenir au début de l'histoire</a></p>
            @endif
        </div>

    @else
        <h3>Le chapitre n'existe pas</h3>
    @endif
@endsection




