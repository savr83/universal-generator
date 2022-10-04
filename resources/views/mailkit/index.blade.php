@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Mailkit v001</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div id="root"></div>
                        @vite('resources/js/mailkit/app.jsx')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
