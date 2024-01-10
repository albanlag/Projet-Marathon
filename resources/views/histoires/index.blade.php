@extends("templates.app")

@section('content')
    <div class="container">
        @if(! empty($histoires))
            <h4>Filtrer par genre</h4>
            <form action="{{route('histoires')}}" method="get">
                <select name="cat">
                    <option value="All" @if($cat == 'All') selected @endif>-- Tous les genres --</option>
                    @foreach($genres as $genre)
                        <option value="{{$genre}}" @if($cat == $genre) selected @endif>{{$genre}}</option>
                    @endforeach
                </select>
                <select name="active">
                    <option value="0" @if($active == 0) selected @endif>Non visible</option>
                    <option value="1" @if($active == 1) selected @endif>Visible</option>
                </select>
                <input type="submit" value="OK">
            </form>
            <section class="histoires_tout">
            @foreach($histoires as $histoire)
            <div class="histoire">
                <a href="{{Route('user.personal', $histoire->user->id)}}">
                <h1>{{$histoire->titre}}</h1>
                </a>
                <a href="{{Route('histoire.show', $histoire->id)}}">
                    @if(str_contains($histoire->photo, 'http'))
                        <img src="{{$histoire->photo}}" alt="Pas d'image">
                    @else
                        <img src="{{Storage::url($histoire->photo)}}" alt="Pas d'image">
                    @endif
                    <p class="histoire-pitch">{{$histoire->pitch}}</p>
                    <p class="histoire-user">{{$histoire->user->name}}</p>
                </a>
                <hr>
                </div>
            @endforeach
        @else
            <p>Pas d'histoire</p>
        @endif
    </section>
    </div>

@endsection

