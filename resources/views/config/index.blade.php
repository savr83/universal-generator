<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        {{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}
        {{--<link href="{{@vite('../../assets/sass/app.scss')}}" rel="stylesheet" type="text/css">--}}
    </head>
    <body>
        <div class="container">

            <div id="root"></div>
            <script src="{{@vite('../../assets/js/app.jsx')}}" ></script>
            <br />

            <div class="content">
                Config list:
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Controls</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($configs->all() as $config)
                        <tr>
                            <th>{{ $config->name }}</th>
                            <td>
                                <button type="button" class="btn btn-primary">Primary</button>
                                <button type="button" class="btn btn-secondary">Secondary</button>
                                <button type="button" class="btn btn-success">Success</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
