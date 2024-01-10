@extends("templates.app")

@section('content')
<div class="formulaire_couleur">
<section class="container formulaire">
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{route("register")}}" method="post">
    <h1>Inscrivez-vous !</h1>
    @csrf

    <div>
    <label for="nom">Prénom</label>
    <input type="text" name="name" required/>
    </div>

    <div>
    <label for="nom">E-mail</label>
    <input type="email" name="email" required/>
    </div>

    <div>
    <label for="nom">Mot de passe</label>
    <input type="password" name="password" required/>
    </div>

    <div>
    <label for="nom">Confirmation de mot de passe</label>
    <input type="password" name="password_confirmation" required/>
    </div>

    <div>
        <button type="submit">Envoyer</button>
    </div>
</form>
<p class="compte">Déjà un compte ? <a href="{{route("login")}}">Connectez vous</a></p>

</section>
</div>

@endsection
