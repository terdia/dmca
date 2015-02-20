@extends('app')
@section('content')
    <h1 class="page-heading">Prepare a DMCA Notice</h1>
    @include('errors.list')
    {!! Form::open(['method' => 'GET', 'action' => 'NoticesController@confirm']) !!}
    <div class="form-group">
        {!! Form::label('provider_id', 'Who should we submit this request to?:') !!}
        {!! Form::select('provider_id', $providers, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('infringing_title', 'The title that was infringed upon:') !!}
        {!! Form::text('infringing_title', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('infringing_link', 'Link to infringing content:') !!}
        {!! Form::text('infringing_link', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('original_link', 'Verify ownership by providing link to the original content in your server:') !!}
        {!! Form::text('original_link', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('original_description', 'Brief DMCA Notice Information:') !!}
        {!! Form::textarea('original_description', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Preview Notice', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
@endsection
@stop