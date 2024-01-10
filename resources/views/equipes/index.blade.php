@extends('templates.app')

@section('content')
    <div class="container equipe">
        <h1>{{ $equipe['nomEquipe'] }}</h1>

        <img src="{{ asset('storage/images/' .$equipe['logo'] )}}" alt="{{ $equipe['nomEquipe'] }} Logo" style="max-width: 200px;">

        <p><strong>Slogan:</strong> {{ $equipe['slogan'] }}</p>
        <p><strong>Localisation:</strong> {{ $equipe['localisation'] }}</p>

        <h2>Membres de l'équipe</h2>
        <div class="row">
            @foreach($equipe['membres'] as $membre)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="{{ asset('storage/images/'. $membre['image']) }}" class="card-img-top" alt="{{ $membre['prenom'] }} {{ $membre['nom'] }}">

                        <div class="card-body">
                            <h5 class="card-title">{{ $membre['prenom'] }} {{ $membre['nom'] }}</h5>
                            <p class="card-text">
                                <strong>Fonctions:</strong> {{ implode(', ', $membre['fonctions']) }}
                            </p>
                            <hr>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <p><strong>Autres:</strong> {{ $equipe['autres'] }}</p>
    </div>
@endsection
