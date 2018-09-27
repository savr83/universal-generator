<html>
    <head>
    {!! $head !!}
    <style>
        .blade-header {
            margin: 8px;
            background: #f0e68c;
        }
        .blade-body {
            margin: 8px;
        }
    </style>
    </head>
    <body>
        <div class="blade-header">
        <div>From: {{ $from }}</div>
        <div>Subj: {{ $subj }}</div>
        <div>Original message type: {{ $type }} received at: {{ $date }}</div>
        <hr />
        </div>
        <div class="blade-body">{!! $body !!}</div>
    </body>
</html>