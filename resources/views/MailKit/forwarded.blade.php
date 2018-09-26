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
<div>From: {{ $from }} at: {{ $date }}</div>
<div>Subj: {{ $subj }}</div>
<hr />
</div>
<div class="blade-body">{!! $body !!}</div>
</body>