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
                        <script src="{{asset(@vite('js/mailkit/app.js'))}}" defer></script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
