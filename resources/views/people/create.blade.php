@extends('base')

@section('title', 'Ajouter une personne')

@section('content')
    <h2>Ajouter un membre de la famille de {{ $person->first_name }}</h2>

    @if(session('error'))
        <p class="text-danger">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('people.store') }}">
        @csrf

        <input type="hidden" name="id" value="{{ $person->id }}">

        <div>
            <label for="first_name">Prénom</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
            @error('first_name') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="last_name">Nom</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required>
            @error('last_name') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="birth_name">Nom de naissance</label>
            <input type="text" name="birth_name" value="{{ old('birth_name') }}">
            @error('birth_name') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="middle_names">Deuxième(s) prénom(s)</label>
            <input type="text" name="middle_names" value="{{ old('middle_names') }}">
            @error('middle_names') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="date_of_birth">Date de naissance</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
            @error('date_of_birth') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="relation_type">Relation</label>
            <select name="relation_type" required>
                <option value="">Sélectionner le type de relation</option>
                <option value="parent" {{ old('relation_type') == 'parent' ? 'selected' : '' }}>Parent</option>
                <option value="child" {{ old('relation_type') == 'child' ? 'selected' : '' }}>Enfant</option>
            </select>
            @error('relation_type') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <button type="submit">Créer</button>
        </div>
    </form>
@endsection
