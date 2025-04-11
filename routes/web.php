<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



use App\Http\Controllers\PersonController;
Route::get('/listp', [PersonController::class, 'listp'])->name('people.listp');

Route::get('/people', [PersonController::class, 'index'])->name('people.index');



Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');
Route::get('/create/{id}', [PersonController::class, 'create'])->middleware('auth')->name('people.create');
Route::post('/people', [PersonController::class, 'store'])->middleware('auth')->name('people.store');


Route::post('/login', [PersonController::class, 'checklog'])->name('people.checklog');
Route::post('/logout', [PersonController::class, 'logout'])->name('people.logout');
Route::get('/sign', [PersonController::class, 'sign'])->name('people.sign');
Route::post('/checksign', [PersonController::class, 'checksign'])->name('people.checksign');
Route::get('/invitcode', [PersonController::class,'invitcode'])->name('people.invitcode');
Route::post('/checkinvit', [PersonController::class, 'checkinvit'])->name('people.checkinvit');
Route::post('/checksign2', [PersonController::class, 'checksign2'])->name('people.checksign2');
Route::get('/proposer/{id}', [PersonController::class,'proposer'])->name('people.proposer');
Route::get('/saveproposition/{id}/{person}/{link}', [PersonController::class, 'saveproposition'])->name('people.saveproposition');
Route::get('/valider/{id}/{p}/{p2}/{link}', [PersonController::class, 'valider'])->name('people.valider');
Route::get('/refuser/{id}/{p}/{p2}/{link}', [PersonController::class, 'refuser'])->name('people.refuser');



Route::get('/test-parentlink', function() {
    $startPerson = App\Models\Person::find(84); 
    
    $targetId = 1265; 
    
    // Exécution du test
    DB::enableQueryLog();
    $startTime = microtime(true);
    
    $result = $startPerson->parentlink($targetId);
    
    $executionTime = round(microtime(true) - $startTime, 3);
    $queryCount = count(DB::getQueryLog());
    
    // Affichage des résultats
    echo "<h1>Test de parentlink()</h1>";
    echo "<p><strong>Degré de parenté:</strong> " . ($result['degree'] ?? 'Aucun lien trouvé') . "</p>";
    
    if (isset($result['path'])) {
        // Récupère les noms des personnes pour un affichage plus clair
        $pathNames = [];
        foreach ($result['path'] as $personId) {
            $person = App\Models\Person::find($personId);
            $pathNames[] = $person->first_name . ' ' . $person->last_name;
        }
        echo "<p><strong>Chemin:</strong> " . implode(' → ', $pathNames) . "</p>";
    }
    
    echo "<p><strong>Temps d'exécution:</strong> {$executionTime}s</p>";
    echo "<p><strong>Nombre de requêtes SQL:</strong> {$queryCount}</p>";
    
    // Dump complet pour debug
    dump($result);
    dump(DB::getQueryLog());
})->name('people.test-parentlink');;