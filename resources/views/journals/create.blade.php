@extends('layouts.app')

@section('content')
    <div class="container">
        <journal-form :client-id="@json($clientId)"></journal-form>
    </div>
@endsection
