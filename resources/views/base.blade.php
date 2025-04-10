<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <main>
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
    </main>
    <title>@yield('title', 'Généalogie')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h1>Bienvenue sur la gestion des personnes</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('people.index') }}">Liste des personnes</a></li>
                    @auth
                        <li>
                            <form method="POST" action="{{ route('people.logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit">Se déconnecter</button>
                            </form>
                        </li>
                        <a href="{{ route('people.listp') }}"> valider des proposition</a>

                    @else
                        <li>
                            <form method="POST" action="{{ route('people.checklog') }}" style="display:inline;">
                                @csrf
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
                                <button type="submit">Se connecter</button>
                            </form>
                            <a href="{{ route('people.sign') }}">s'inscire</a>
                            <a href="{{ route('people.invitcode') }}">invité?</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <p>&copy; 2024 Généalogie</p>
        </footer>
    </div>
</body>
</html>
