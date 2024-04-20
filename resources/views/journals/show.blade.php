@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <journal-show :journal='@json($journal)'></journal-show>
    </div>
@endsection
