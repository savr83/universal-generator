@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                         DataBase Editor приложение Laravel+React!

                        <div id="example"></div>
                        <script src="{{asset(mix('js/app.js'))}}" defer></script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
