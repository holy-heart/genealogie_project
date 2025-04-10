@extends('base')

@section('title', 'verifier le code (id de la person)')

@section('content')
    <div>
        <form method="POST" action="{{ route('people.checkinvit') }} "  style="display:inline;">
            @csrf
            <label for="code">entrer le code d'invite</label>
            <input type="text" name="code" value="{{ old('code') }}" required>
            @error('code')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <button type="submit">verifier</button>
        </form>
    </div>
@endsection
