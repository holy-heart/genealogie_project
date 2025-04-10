@extends('base')

@section('title', 'inscrit toi')

@section('content')
    <div>
        <form method="POST" action="{{ route('people.checksign2') }} "  style="display:inline;">
            @csrf
            
            <input type="hidden" name="id" value="{{ $id }}">


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
            <button type="submit">verifier</button>
        </form>
    </div>
@endsection
