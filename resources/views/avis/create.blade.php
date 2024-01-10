@extends("templates.app")

@section('content')
    <form action="{{Route('avis.store')}}" method="post">
        @csrf
        <div>
            <label for="contenu"><strong>contenu</strong></label>
            <textarea name="contenu" id="contenu" rows="6" placeholder="contenu.."></textarea>
        </div>
        <input type="hidden" name="histoire_id" value="{{$histoire_id}}">
        <input type="submit" name="submit" value="submit">
    </form>
@endsection