@extends('layouts.app')

@section('content')

<h1>List</h1>
    @if (count($notes) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>title</th>
                    <th>contents</th>
                    <th>picture</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $notes)
                <tr>
                    <td>{!! link_to_route('notes.show', $notes->id, ['id' => $notes->id]) !!}</td>
                    <td>{{ $notes->status }}</td>
                    <td>{{ $notes->content }}</td>
                    <td><img src ="{{ asset('/storage/'.$notes->image_path)}}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
 {!! link_to_route('notes.create', 'New Note Create', [], ['class' => 'btn btn-primary']) !!}

@endsection