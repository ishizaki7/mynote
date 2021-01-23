@extends('layouts.app')

@section('content')

<h1>Detail of No. {{ $note->id }}</h1>

    <table class="table table-bordered">
        
        <tr>
            <th>title</th>
            <td>{{ $note->status }}</td>
        </tr>
        <tr>
            <th>Note</th>
            <td>{{ $note->content }}</td>
        </tr>
        　　<th>Picture</th>
            <th><img src ="{{ asset('/storage/'.$note->image_path)}}"></th>

    </table>
 {!! link_to_route('notes.edit', 'このNoteを編集', ['id' => $note->id], ['class' => 'btn btn-light']) !!}
 {!! Form::model($note, ['route' => ['notes.destroy', $note->id], 'method' => 'delete']) !!}
        {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

@endsection