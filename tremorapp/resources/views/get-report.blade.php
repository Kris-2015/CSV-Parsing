@extends('layouts.template')

@section('title', 'Report')

@section('css')
<link rel="stylesheet" href="{{ url('css/login-modal.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row row-centered">
        <div class="col-xs-6 col-centered">
            <a href="#" id="pop-modal">Medical Report</a>
            <br><br>
        </div>
    </div>
</div>

<!-- Report Login Download Modal -->
<div class="modal fade" id="login" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        
        <!-- Modal Content -->
        <div class="modal-content">
            {{ Form::open(array(
                'url' => route("getReport"), 
                'method' => 'POST', 
                'class' => 'form-horizontal', 
                'id' => 'getReport', 
                'data-validurl' => route("downloadReport"), 
            )) }}
                <div class="modal-header">
                    <p><strong id="heading">Enter your Pin Number</strong></p>
                </div>
                <div class="modal-body" >
                    <div class="pin-error-ctr">

                    </div>
                    <div class="form-group">
                        {{ Form::label('pin', 'PIN:', array('class' => 'control-label col-sm-3')) }}
                        <div class="col-sm-6">
                            {{ Form::text('pin', null, array('class' => 'form-control')) }}
                        </div>                        
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <p><strong><u>Forgot Pin!</u></strong><br>
                                Please contact <a href="#">support@mytremor.org</a></p>
                        </div>
                    </div>

                </div>

                <!-- Add hashId and token Id in hidden field -->
                {{ Form::hidden('tokenId', $url['tokenId']) }}
                {{ Form::hidden('hashId', $url['hashId']) }}

                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-submit">Submit</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Html::script('js/report-popup.js') !!}
@endsection