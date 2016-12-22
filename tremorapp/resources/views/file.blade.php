@extends('layouts.template')

@section('title', 'Report')

@section('content')
<p>Hello</p><br>

{{ dd( url('tremor_document/web/index.php') ) }}
<!-- <h4><a href="{{  }}">Document</a></h4> -->
@endsection