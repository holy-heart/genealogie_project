@extends('base')

@section('title', 'inscrit toi')

@section('content')
    
    <div>
        <table>
            <thead>
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
