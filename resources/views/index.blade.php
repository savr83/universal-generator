@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">CRM Kit</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="links">
                            <a href="https://github.com/savr83/universal-generator">GitHub</a>
                            <a href="{{ url('/home') }}">Home</a>
                            <a href="{{ url('/mailkit') }}">MailKit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
