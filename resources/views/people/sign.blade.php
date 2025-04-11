@extends('base')

@section('title', "S'inscrire")

@section('content')
    <h2>Créer un compte</h2>

    <form method="POST" action="{{ route('people.checksign') }}">
        @csrf

        {{-- Informations de connexion --}}
        <fieldset>
            <legend>Informations de connexion</legend>

            <label for="name">Nom d'utilisateur :</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required><br>
            @error('name') <small class="text-danger">{{ $message }}</small><br> @enderror

            <label for="email">Adresse e-mail :</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required><br>
            @error('email') <small class="text-danger">{{ $message }}</small><br> @enderror

            <label for="password">Mot de passe :</label><br>
            <input type="password" name="password" required><br>
            @error('password') <small class="text-danger">{{ $message }}</small><br> @enderror
        </fieldset>

        <br>

        {{-- Informations personnelles --}}
        <fieldset>
            <legend>Informations personnelles</legend>

            <label for="first_name">Prénom :</label><br>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required><br>
            @error('first_name') <small>{{ $message }}</small><br> @enderror

            <label for="last_name">Nom :</label><br>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required><br>
            @error('last_name') <small>{{ $message }}</small><br> @enderror

            <label for="birth_name">Nom de naissance :</label><br>
            <input type="text" name="birth_name" value="{{ old('birth_name') }}"><br>
            @error('birth_name') <small>{{ $message }}</small><br> @enderror

            <label for="middle_names">Deuxième(s) prénom(s) :</label><br>
            <input type="text" name="middle_names" value="{{ old('middle_names') }}"><br>
            @error('middle_names') <small>{{ $message }}</small><br> @enderror

            <label for="date_of_birth">Date de naissance :</label><br>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"><br>
            @error('date_of_birth') <small>{{ $message }}</small><br> @enderror
        </fieldset>

        <br>

        <button type="submit">S'inscrire</button>
    </form>
@endsection
