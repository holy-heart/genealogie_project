<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Relationship;
use App\Models\User;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::with('createdBy')->orderBy('created_at', 'desc')->get();
        return view('people.index', compact('people'));
    }
    public function show($id)
    {
        $person = Person::with(['children', 'parents'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

    public function create($id)
    {
        if (!auth()->check()) {
            return redirect()->route('people.index')->with('error', 'Il faut vous connecter');
        }
        $person = Person::with(['children', 'parents'])->findOrFail($id);

        return view('people.create', compact('person'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('people.index')->with('error', 'Il faut vous connecter');
        }

        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birth_name'    => 'nullable|string|max:255',
            'middle_names'  => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'id' => 'nullable|integer',
        ]);

        $person = new Person();
        $person->first_name= ucfirst(strtolower($request->first_name));
        $person->last_name  = strtoupper($request->last_name);
        $person->birth_name  = $request->birth_name ? strtoupper($request->birth_name) : strtoupper($request->last_name);
        $person->middle_names = $this->formatMiddleNames($request->middle_names);
        $person->date_of_birth = $request->date_of_birth ?: null;
        $person->created_by = auth()->id();
        $person->save();

        $remationship = new Relationship();
        if($request->relation_type === 'parent')
        {
            $remationship->parent_id= $person->id;
            $remationship->child_id= $request->id;
        }
        else {
            $remationship->parent_id= $request->id;
            $remationship->child_id= $person->id;
        }
        $remationship->created_by = auth()->id();
        $remationship->save();

        return redirect()->route('people.index')->with('success', "Opération réussie, son id est {$person->id}");
    }

    // Connexion
    public function checklog(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            auth()->login($user);
            return redirect()->route('people.index')->with('success', "Vous êtes connecté {$user->name}");
        }

        return redirect()->route('people.index')->with('error', 'Email ou mot de passe incorrect');
    }

    // Déconnexion
    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
            return redirect()->route('people.index')->with('success', 'Vous êtes déconnecté');
        }
        return redirect()->route('people.index')->with('success', 'Vous êtes déjà déconnecté');
    }

    private function formatMiddleNames($middle_names)
    {
        if (!$middle_names) {
            return null;
        }

        $middle_names_array = explode(',', $middle_names);

        return implode(', ', array_map(function ($name) {
            return ucfirst(strtolower(trim($name)));
        }, $middle_names_array));
    }





    public function sign()
    {
        return view('people.sign');
    }

    public function checksign(Request $request)
    {
        
        if (auth()->check()) {
            return redirect()->route('people.index')->with('error', 'Vous devait être déconnecté');
        }
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birth_name'    => 'nullable|string|max:255',
            'middle_names'  => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        $userv = User::where('email', $request->email)->first();

        if ($userv) {
            return redirect()->route('people.sign')->with('error', 'ce compte existe eja');
        }

        


        $user = new User();
        $user->name    = $request->name;
        $user->email     = $request->email;
        $user->password    = $request->password;
        $user->save();

        
        auth()->login($user);
        $person = new Person();
        $person->first_name    = ucfirst(strtolower($request->first_name));
        $person->last_name     = strtoupper($request->last_name);
        $person->birth_name    = $request->birth_name ? strtoupper($request->birth_name) : strtoupper($request->last_name);
        $person->middle_names  = $this->formatMiddleNames($request->middle_names);
        $person->date_of_birth = $request->date_of_birth ?: null;
        $person->created_by    = auth()->id();
        $person->save();
        auth()->logout();

        return redirect()->route('people.index')->with('success', 'vous avez cree cotre compte bravo, conncecter vous');
    }



    public function invitcode()
    {
        if(auth()->check()) {
            return redirect()->route('people.index')->with('error','tu est deja connceté');
        }
        return view('people.invitcode');
    }


    public function checkinvit(Request $request)
    {
        
        $person = Person::with(['children', 'parents'])->findOrFail($request->code);
        if($person)
        {
            return view('people.confirm',['id'=> $request->code]);
        }
        return redirect()->route('people.index')->with('error','dsl mais personne a cree ton profil au paravant');
    }


    public function checksign2(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);


        


        $user = new User();
        $user->name    = $request->name;
        $user->email     = $request->email;
        $user->password    = $request->password;
        $user->save();

        auth()->login($user);
        $person = Person::with(['children', 'parents'])->findOrFail($request->id);
        $person->created_by = auth()->id();
        $person->save();
        auth()->logout();


        return redirect()->route('people.index')->with('success', 'vous avez cree cotre compte bravo, conncecter vous');
    }



    public function proposer($id)
    {
        $people = Person::with('createdBy')->orderBy('created_at', 'desc')->get();

        return view('people.proposition',['id'=> $id, 'people' => $people]);
    }

    

    public function saveproposition($id, $person, $link)
    {   

        $data = [
            'person' => $person,
            'link'=> $link,
            'person2' => strval($id), 
            'validation' => 0,
            'refus'=> 0
        ];
        $R = session("Rela" , []);
        $R[] = $data;

        session(['Rela'=> $R]);
        return redirect()->route('people.index')->with('success', 'proposition sauvegardée');
    }
    public function listp(){
        return view('people.listeproposition');
    }

    public function valider($p, $p2,$link)
    {
        $R = session('Rela', []);

        foreach ($R as $key => $r) {
            if ($r['person'] === $p && $r['person2'] === $p2 && $r['link'] === $link) {
                $R[$key]['validation'] += 1;
                if ($R[$key]['validation'] >= 3  || auth()->id() === $p || auth()->id() === $p2) {
                    unset($R[$key]);
                    $relationship = new Relationship();
                    $relationship->parent_id = ($r['link'] === 'child') ? $p2 : $p;
                    $relationship->child_id = ($r['link'] === 'child') ? $p : $p2;
                    $relationship->created_by = auth()->id() ?? 0;
                    $relationship->save();
                    session(['Rela' => array_values($R)]);
                    return redirect()->route('people.index')->with('success', 'Relationship validated.');
                }

                session(['Rela' => $R]);
                return redirect()->route('people.index')->with('success', 'Validation incremented.');
            }
        }
        return redirect()->route('people.index')->with('error', 'Proposition not found.');
    }

    public function refuser($p, $p2,$link)
    {
        $R = session('Rela', []);

        foreach ($R as $key => $r) {
            if ($r['person'] === $p && $r['person2'] === $p2 && $r['link'] === $link) {
                $R[$key]['refus'] += 1;
                if ($R[$key]['refus'] >= 3 || auth()->id() === $p || auth()->id() === $p2) {
                    unset($R[$key]);
                    session(['Rela' => array_values($R)]);
                    return redirect()->route('people.index')->with('success', 'Relationship suprimé.');
                }
                session(['Rela' => $R]);
                return redirect()->route('people.index')->with('success', 'refus incrementé.');
            }
        }
        return redirect()->route('people.index')->with('error', 'Proposition not found.');
    }
}
