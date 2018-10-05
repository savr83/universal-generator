@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Mailkit</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div id="mailkit"></div>
                        <script src="{{mix('js/mailkit/app.js')}}" ></script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
