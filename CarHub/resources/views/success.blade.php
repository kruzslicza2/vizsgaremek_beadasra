@extends('layout')
@section('content')
<div class="container py-4">
    <div class="alert alert-success text-center">
        {{ $message }}
    </div>
    <div class="text-center">
        <a href="{{ route('cars.index') }}" class="btn btn-primary">Vissza a hirdetésekhez</a>
    </div>
</div>
@endsection
