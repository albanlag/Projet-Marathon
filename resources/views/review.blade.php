@extends("templates.app")
@section('content')
<div class="fond_review">
    

<div class="video">
    <video controls>
        <source src="{{Vite::asset('resources/videos/Groupe-9.mp4')}}" type="video/mp4" />
        <p>Votre navigateur ne prend pas en charge les vidéos HTML5.</p>
    </video>
</div>
<h1 class="titre_review">Interview d'un visiteur et d'un auteur de notre site web</h1>
</div>
@endsection