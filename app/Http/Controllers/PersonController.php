<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Relationship;
use App\Models\User;
use App\Models\Propositions;

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
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'birth_name'  => 'nullable|string|max:255',
            'middle_names'=> 'nullable|string|max:255',
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
            'first_name' => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'birth_name'  => 'nullable|string|max:255',
            'middle_names' => 'nullable|string|max:255',
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


        return redirect()->route('people.index')->with('success', "vous avez cree cotre compte en tant qu'invté bravo, conncecter vous");
    }



    public function proposer($id)
    {
        $people = Person::with('createdBy')->orderBy('created_at', 'desc')->get();

        return view('people.proposition',['id'=> $id, 'people' => $people]);
    }

    

    public function saveproposition($id, $person, $link)
    {   

                
        $propositions = new Propositions();
        $propositions->created_by = auth()->id();
        $propositions->person = $person;
        $propositions->link = $link;
        $propositions->person2 = strval($id);
        $propositions->save();

        
        return redirect()->route('people.index')->with('success', "proposition sauvegardée, d'autres utilisateur peuvent valider ou refuser cette proposition dans 'Valider des propositions'");
    }
    public function listp(){
        $propositions = Propositions::with('createdBy')->get();

        return view('people.listeproposition', compact('propositions'));
    }

    public function valider($id, $p, $p2, $link)
    {
        $propositions = Propositions::findOrFail($id);

        $propositions->validation += 1;
        if ($propositions->validation >= 3  || strval(auth()->id()) === $p || strval(auth()->id()) === $p2) {
            $relationship = new Relationship();
            $relationship->parent_id = ($propositions->link === 'child') ? $p2 : $p;
            $relationship->child_id = ($propositions->link === 'child') ? $p : $p2;
            $relationship->created_by = auth()->id() ?? 0;
            $relationship->save();
            $propositions->delete();
            return redirect()->route('people.index')->with('success', 'Relationship validated.');
        }
        $propositions->save();
        $propIds = session('propo', []);

        $propIds[] = $id;
        session(['propo' => $propIds]); 

        return redirect()->route('people.index')->with('success', 'vous avez soutenu la relation avec +1.');
    }

    public function refuser($id, $p, $p2,$link)
    {
        $propositions = Propositions::findOrFail($id);

        $propositions->refus += 1;
        if ($propositions->refus >= 3  || strval(auth()->id()) === $p || strval(auth()->id()) === $p2) {
            $propositions->delete();
            return redirect()->route('people.index')->with('success', 'Relationship deleted.');
        }
        $propositions->save();

        $propIds = session('propo', []);
        $propIds[] = $id;
        session(['propp' => $propIds]); 

        return redirect()->route('people.index')->with('success', 'vous avez affaiblie la relation avec +1.');
    }
}
