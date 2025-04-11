
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Généalogie')</title>
</head>
<body>
    <header>
        <div style="padding: 10px; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; align-items: center;">
            <img src="{{ asset('images/LOGO-OCD.png') }}" alt="logo" width="150">
            <div>
                <h1 style="margin: 0;"><a href="{{ route('people.index') }}" style="margin-right: 10px;">Demo Généalogie Collaborative</a></h1>
                <p>ici, la réponse a <a href="{{ route('people.test-parentlink') }}">Partie 2</a></p>
            </div>

            <div>
                @auth
                    <div>
                        <span>user : {{ auth()->user()->name }}</span>
                        <a href="{{ route('people.listp') }}" style="margin-left: 15px;">Valider des propositions</a>
                        <form method="POST" action="{{ route('people.logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit">Se déconnecter</button>
                        </form>
                    </div>
                @else
                    <form method="POST" action="{{ route('people.checklog') }}" style="display:inline; margin-right: 10px;">
                        @csrf
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <button type="submit">Se connecter</button>
                    </form>

                    <a href="{{ route('people.sign') }}" style="margin-right: 10px;">S'inscrire</a>
                    <a href="{{ route('people.invitcode') }}">Invité ?</a>
                @endauth
            </div>
        </div>
    </header>
    <main style="padding: 20px;">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer style="text-align: center; padding: 10px; border-top: 1px solid #ccc;">
        <p>&copy; 2025 Généalogie</p>
    </footer>
</body>
</html>
