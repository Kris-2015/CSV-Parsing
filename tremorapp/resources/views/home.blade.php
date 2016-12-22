@extends('layouts.app')

@section('Tremor', 'title')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Tremor App
        </div>

        <div class="links">
            <a href="{{ url('/') }}">Creating your own report in your palm.</a>
        </div>
    </div>
</div>
@endsection