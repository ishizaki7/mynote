@extends('layouts.app')

@section('content')

 <h1>New Note Create</h1>

    <div class="row">
        <div class="col-6">
            
            {!! Form::model($note, ['route' => 'notes.store','files' => true]) !!}
        
        <div class="form-group">
                    {!! Form::label('status', 'Title:') !!}
                    {!! Form::text('status', null, ['class' => 'form-control']) !!}
                </div>
            
                <div class="form-group">
                    {!! Form::label('content', 'Note:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>
                 <div class="form-group">
                     {!! Form::label('picture', 'Picture:') !!}
                    {!! Form::file('image') !!}
                </div>

                {!! Form::submit('Post', ['class' => 'btn btn-primary']) !!}
                
            {!! Form::close() !!}
        </div>
    </div>
@endsection