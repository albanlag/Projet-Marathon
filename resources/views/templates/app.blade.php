<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{isset($title) ? $title : "Page en cours"}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.typekit.net/izh4ltj.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite(["resources/css/normalize.css", 'resources/css/style.css', 'resources/js/javascript.js'])
</head>
<body>
<header id="menuBar" class="header">
    <div class="debut_header"></div>
    <div class="menu-burger" id="menuBurger">
        <div class="nav-container">
            <input class="checkbox" type="checkbox" name="" id="" />
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>  
            <div class="menu-items">
                <li id="creer_une_histoire">
                    @auth
                    <a href="{{route('histoires.create')}}">Créer une histoire</a>
                    @else
                    <style>
                        #creer_une_histoire{
                            display: none;
                        }
                    </style>
                    @endauth
                </li>
                <li><a href="{{route('histoires')}}">Liste des histoires</a></li>
                <li><a href="{{route('equipe.index')}}">Notre équipe</a></li>
                <li><a href="{{route('contact.form')}}">Contact</a></li>
                <li><a href="{{route('review')}}">Review</a></li>
            </div>
        </div>
    </div>
    <div class="Logo">
        <a href="{{route('index')}}"><img src="{{Vite::asset('resources/images/FromTheSky.svg')}}"><h1>From The Sky</h1></a>
    </div>
    <div class="reste_header">
        @auth
            <a href="{{ route('user.personal', ['userId' => auth()->id()]) }}">{{Auth::user()->name}}</a>
            <a href="{{route("logout")}}"
            onclick="document.getElementById('logout').submit(); return false;">Se  déconnecter</a>
            <form id="logout" action="{{route("logout")}}" method="post">
                @csrf
            </form>
        @else
            <a href="{{route("login")}}" class="bouton_inscription">Se connecter</a>
            <a href="{{route("register")}}" class="bouton_connexion">S'inscrire</a>
        @endauth
    </div>
</header>


<main>
    @yield("content")
</main>

<footer>
    <div class="footer_tout">
        <div class="footer_logo">
            <a href="{{route('index')}}"><img src="{{Vite::asset('resources/images/FromTheSky.svg')}}"><h1>From The Sky</h1></a>
        </div>
        <div class="footer_texte">
            <p>Conditions d’utilisation</p>
            <p>Contact</p>
            <p>Notre équipe</p>
        </div>
    </div>
    <p class="copyright">© 2023 Les paquetas. All rights reserved.</p>
</footer>
</body>
</html>
