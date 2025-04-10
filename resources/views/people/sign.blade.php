@extends('base')

@section('title', "s'inscrire")

@section('content')
    <div>
        <form method="POST" action="{{ route('people.checksign') }}" style="display:inline;">
            @csrf
            <label for="name">nom</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <label for="email">Adresse mail</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <label for="password">Mot de passe</label>
            <input type="password" name="password" required>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror





            <label for="first_name">Prénom</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
            @error('first_name') <small>{{ $message }}</small> @enderror

            <label for="last_name">Nom</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required>
            @error('last_name') <small>{{ $message }}</small> @enderror

            <label for="birth_name">Nom de naissance</label>
            <input type="text" name="birth_name" value="{{ old('birth_name') }}">
            @error('birth_name') <small>{{ $message }}</small> @enderror

            <label for="middle_names">Deuxième(s) prénom(s)</label>
            <input type="text" name="middle_names" value="{{ old('middle_names') }}">
            @error('middle_names') <small>{{ $message }}</small> @enderror

            <label for="date_of_birth">Date de naissance</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
            @error('date_of_birth') <small>{{ $message }}</small> @enderror


            
            <button type="submit">Se connecter</button>
        </form>
    </div>
@endsection
