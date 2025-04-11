<?php

use App\Models\Person;

?>

@extends('base')

@section('title', 'Liste des propositions')

@section('content')
        <div style="background-color: #d4edda; color: #155724; padding: 1px; margin-bottom: 10px; border: 1px solid #c3e6cb;">
            <p>ici vous pouvez soit valider une proposition, ou la refuser, vous n'avez pas accés au proposition que vous avez vous meme faites.
            </p>
        </div>
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th>Nom de la personne</th>
                    <th>Lien</th>
                    <th>Personne liée</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($propositions as $relation)
                    @php
                        $propIds = session('propo', []);
                    @endphp
                    @if(!in_array(strval($relation->id), $propIds))
                        @php
                            $person1 = Person::find($relation->person);
                            $person2 = Person::find($relation->person2);
                        @endphp
                        @if($person1 && $person2)
                            @if(auth()->id() !== $relation->created_by)
                                <tr>    
                                    <td>{{ $person1->last_name}} {{ $person1->first_name }}</td>
                                    <td>{{ $relation->link === 'child' ? 'enfant' : 'parent' }} de </td>
                                    <td>{{ $person2->last_name }} {{ $person2->first_name }}</td>
                                    <td>
                                        <a href="{{ route('people.valider', ['id'=> strval($relation->id), 'p' => $relation->person, 'link' => $relation->link, 'p2' => $relation->person2]) }}">
                                            Valider
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('people.refuser', ['id'=> strval($relation->id), 'p' => $relation->person, 'link' => $relation->link, 'p2' => $relation->person2]) }}">
                                            Refuser
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endif
                @endforeach


            </tbody>
        </table>
@endsection