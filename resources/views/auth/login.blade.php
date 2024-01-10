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
    <form action="{{route("login")}}" method="post">
        <h1>Connectez vous !</h1>
        @csrf

        <div>
        <label for="nom">E-mail</label>
        <input type="email" name="email" required/>
        </div>

        <div>
        <label for="nom">Mot de passe</label>
        <input type="password" name="password" required/>
        </div>

        <div>
        <p class="remember-me">Remember me<input type="checkbox" name="remember"/></p>
        </div>

        <div>
            <button type="submit">Envoyer</button>
        </div>
    </form>
    <p class="compte">Pas encore de compte ? <a href="{{route("register")}}">Inscrivez vous</a></p>
</section>
</div>
@endsection