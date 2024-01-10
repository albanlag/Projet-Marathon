@extends("templates.app")

@section('content')
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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="user_page">
        <div class="NomUser">
            @if($user->id == auth()->user()->id)
                <h1>Bonjour, {{$user->name}}.</h1>
            @else
                <h1>Page de {{$user->name}}</h1>
            @endif
        </div>
        <div class="Avatar">
            <img class="Avatar_img" src="{{ Storage::url('avatars/'. $user->avatar) }}" alt="Avatar" />
            <i id="avatar" class='bx bxs-pencil'></i>
        @if($user->id == auth()->user()->id)
            <!-- Dans votre vue de mise à jour d'avatar (par exemple, update-avatar.blade.php) -->
            <form id="avatar_form" action="{{ route('user.edit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="avatar_submit"></label>
                <input class="none" id="avatar_submit" type="file" name="new_avatar" accept="image/*" required>
                <button class="none" id="avatar_submit" type="submit">Mettre à jour l'avatar</button>
            </form>


            <script>
                let myAvatar = document.getElementById('avatar');
                myAvatar.addEventListener('click', (e) => {
                    document.getElementById('avatar_submit').click();
                })
                document.getElementById('avatar_submit').addEventListener('change', (e) => {
                    document.getElementById('avatar_form').submit(); return false;
                })
            </script>
        @endif
        </div>

        <div class="ToutTableau">
            <div class="T_head">
                <span>Vous avez terminés {{ $histoiresTerminees }} histoires</span>
                <span>Vous avez postés {{ $avisPostes }} commentaires</span>
            </div>
            <div class="T_foot">
                <div class="T_foot_gauche">
                    <span>Vous avez écris {{ $histoiresEcrites }} histoires</span>
                    <div class="CreatedHistoire">
                        <h2>Histoires Créées:</h2><ul>
                        @forelse($histoiresCrees as $histoire)
                            <li><a href="{{route('histoire.show', ['id' => $histoire->id])}}">{{ $histoire->titre }}</a></li>
                        @empty
                            <p>Aucune histoire créée.</p>
                        @endforelse
                    </ul></div>
                </div>
                <div class="T_foot_milieu">
                    <span>Vous lisez actuellement {{ $histoiresEnCoursDeLecture->count() }} histoires</span>
                    <div class="EnLecture">
                        <h2>Histoires en Cours de Lecture:</h2><ul>
                        @forelse($histoiresEnCoursDeLecture as $titre)
                            <li>{{ $titre->titre }}</li><a>Reprendre la lecture</a>
                        @empty
                            <p>Aucune histoire en cours de lecture.</p>
                        @endforelse
                    </ul></div>
                </div>
                <div class="T_foot_droit">
                    <span>Vous écrivez actuellement {{ $histoiresEnCoursDeCreation->count() }} histoires</span>
                    <div class="HistoireEnCours">
                        <h2>Histoires en Cours de Création:</h2><ul>
                        @forelse($histoiresEnCoursDeCreation as $histoire)
                            @if($histoire->user_id == auth()->user()->id)
                                <li><a href="{{route('histoires.encours', ['id' => $histoire->id])}}">{{ $histoire->titre }}</a></li>
                            @endif
                        @empty
                            <p>Aucune histoire en cours de création.</p>
                        @endforelse
                    </ul></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let avatar = document.getElementById('avatar');
    let avatar_form = document.getElementById('avatar_form');
    let crayon = document.getElementById("crayon");

    avatar.addEventListener('mouseover', e=>{
        avatar_form.style.display = 'block';
        avatar.style.opacity='1';
    });
    avatar.addEventListener("mouseleave", e=>{
        avatar_form.style.display = "none";
        avatar .style.opacity='0';

    });
</script>
@endsection
