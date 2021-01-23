@extends('layouts.app')

@section('content')

    

<h1> Edit of No. {{ $note->id }} </h1>

    <div class="row">
        <div class="col-6">
            {!! Form::model($note, ['route' => ['notes.update', $note->id], 'method' => 'put','files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('status', 'Title:') !!}
                    {!! Form::text('status', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('content', 'Note') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>
                    {!! Form::label('image_path', 'Picture') !!}
                <td><img src ="{{ asset('/storage/'.$note->image_path)}}"></td>
                <div class="form-group">
                     {!! Form::label('image', '選びなおす:') !!}
                    {!! Form::file('image') !!}
                </div>
                
                {!! Form::submit('update', ['class' => 'btn btn-primary']) !!}
        
            {!! Form::close() !!}
        </div>
    </div>

@endsection