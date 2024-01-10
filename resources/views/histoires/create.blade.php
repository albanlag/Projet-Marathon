@extends('templates.app')

@section('content')
    <div class="creation_histoire">
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
        <form action="{{ route('histoires.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="partie_remplissage">
                <div class="gauche">
                    <div class="bloc_newHistoire desc">
                        <h1>Titre de l'histoire</h1>
                        <input type="text" placeholder="Titre" name="titre" required>
                    </div>

                    <div class="bloc_newHistoire desc">
                        <h1>Photo</h1>
                        <input name="image_histoire" placeholder="Insérez un URL" accept="image/*" required>
                    </div>

                    <div class="bloc_newHistoire desc">
                        <h1>Genre</h1>
                        <select name="genre_id" required>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="milieu"></div>
                <div class="droite">
                    <h1>Descriptif</h1>
                    <textarea name="pitch" placeholder="Que voulez-vous nous raconter ?" required></textarea>
                </div>
            </div>
            <div class="bouton_submit_histoire">
                <button type="submit">Créer l'histoire</button>
            </div>
        </form>
    </div>
@endsection
