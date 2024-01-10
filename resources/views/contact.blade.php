@extends("templates.app")

@section('content')
<div class="formulaire_couleur">
<section class="container formulaire">
    <div class="mx-auto mt-16 max-w-xl sm:mt-20 bg-slate-200 p-4 rounded-md border-0">
        @if(session('success'))
            <div class="alert alert-success text-center">
                <h1 class="text-green-500">Votre message à bien été envoyé avec succès !</h1>
                <br/>
                @foreach(session('success') as $message)
                    <p>{{ $message }}</p>
                    <br/>
                @endforeach
                <br/>
                <a href="{{ route('contact.form') }}">Renvoyer un message</a>
                <a href="{{route('index')}}">Revenir à l'accueil</a>
            </div>

        @else

                <form action="" method="post">
                    <h1>Contacter nous !</h1>
                    @csrf
                    <div>
                        <label for="nom">Votre nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div>
                        <label for="nom">Votre Prénom</label>
                        <input type="text" id="nom" name="prenom" required>
                    </div>
                    <div class="my-2">
                        <label for="email">Votre e-mail</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="my-2">
                        <label for="message">Votre message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <div>
                        <button type="submit">Envoyer</button>
                    </div>
                </form>
        @endif
    </div>
    </section>
    </div>
@endsection