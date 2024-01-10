<x-layout>
    <form action="{{route('chapitres.store')}}" method="POST">
        {!! csrf_field() !!}

        <div>
            <label for="titre"><strong>Titre : </strong></label>
            <input type="text" name="titre" id="titre"
                   value="{{ old('titre') }}"
                   placeholder="Le titre">
        </div>

        <div>
            <label for="titrecourt"><strong>Titre court : </strong></label>
            <input type="text" name="titrecourt" id="titrecourt"
                   value="{{ old('titrecourt') }}"
                   placeholder="Le titre court">
        </div>

        <div>
            <label for="texte"><strong>Texte :</strong></label>
            <textarea name="texte" id="texte" rows="6" class="form-control"
                      placeholder="Texte..">{{ old('texte') }}</textarea>
        </div>

        <div class="media">
            <label for="doc"><strong>Media :</strong></label>
            <input type="file" name="document" id="doc">
        </div>

        <div>
            <label for="question"><strong>Question : </strong></label>
            <input type="text" name="question" id="question"
                   value="{{ old('question') }}"
                   placeholder="Question(s)">
        </div>

        <div>
            <label for="premier"><strong>Premier </strong></label>
            <input type="checkbox" id="premier" name="premier"/>

        </div>


        <div>
            <button class="btn btn-success" type="submit">Valider</button>
        </div>
    </form>


</x-layout>


