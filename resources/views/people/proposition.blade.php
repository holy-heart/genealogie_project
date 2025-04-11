@extends('base')

@section('title', 'inscrit toi')

@section('content')
    
    <div>
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>User</th>
                    <th>parent</th>
                    <th>fils</th>
                </tr>
            </thead>
            <tbody>
                @foreach($people as $person)
                    <tr>
                        <td>{{ $person->last_name }}</td>
                        <td>{{ $person->first_name }}</td>
                        <td>{{ $person->createdBy->name }}</td>
                        <td><a href="{{ route('people.saveproposition', ['person' => $person->id, 'id' => $id, 'link' => 'parent']) }}">selectionner</a></td>
                        <td><a href="{{ route('people.saveproposition', ['person' => $person->id, 'id' => $id, 'link' => 'child']) }}">selectionner</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            
           
    </div>
@endsection
