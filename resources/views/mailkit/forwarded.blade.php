<html>
    <head>
    {!! $head !!}
    <style>
        .blade-header {
            margin: 0;
        }
        .blade-body {
            margin: 0;
        }
    </style>
    </head>
    <body>
    <!--
        <div class="blade-header">
            <div>MailKit debug info</div>
            <div>From: {{ $from }}</div>
            <div>Subj: {{ $subj }}</div>
            <div>Original message type: {{ $type }} received at: {{ $date }}</div>
            <div>Detected charset: {{ $charset }}</div>
        </div>
    -->
        <div class="blade-body">{!! $body !!}</div>
    </body>
</html>