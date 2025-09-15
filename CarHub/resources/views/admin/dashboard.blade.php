@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Admin Dashboard</h2>

    <!-- 1. Statisztikák -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm p-3">
                <h5>Összes felhasználó</h5>
                <span class="fs-3 fw-bold">{{ \App\Models\User::count() }}</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm p-3">
                <h5>Összes hirdetés</h5>
                <span class="fs-3 fw-bold">{{ \App\Models\Car::count() }}</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm p-3">
                <h5>Aktív felhasználók</h5>
                <span class="fs-3 fw-bold">{{ \App\Models\User::where('active',1)->count() }}</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm p-3">
                <h5>Kedvencek száma</h5>
                <span class="fs-3 fw-bold">{{ \App\Models\Favorite::count() }}</span>
            </div>
        </div>
    </div>

    <!-- 2. Gyors linkek -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <a href="{{ route('brands.index') }}" class="btn btn-primary w-100 p-4">
                <i class="fas fa-car-side fa-2x"></i><br>Márkák kezelése
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.cars') }}" class="btn btn-success w-100 p-4">
                <i class="fas fa-car fa-2x"></i><br>Hirdetések kezelése
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.users') }}" class="btn btn-warning w-100 p-4">
                <i class="fas fa-users fa-2x"></i><br>Felhasználók kezelése
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('cars.create') }}" class="btn btn-info w-100 p-4">
                <i class="fas fa-plus fa-2x"></i><br>Új hirdetés
            </a>
        </div>
    </div>

    <!-- 3. Legutóbbi aktivitások -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Legutóbbi felhasználók</h5>
                <ul class="list-group list-group-flush">
                    @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                        <li class="list-group-item">
                            {{ $user->username }} ({{ $user->email }})
                            <span class="text-muted float-end">{{ $user->created_at->format('Y-m-d') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Legutóbbi hirdetések</h5>
                <ul class="list-group list-group-flush">
                    @foreach(\App\Models\Car::latest()->take(5)->get() as $car)
                        <li class="list-group-item">
                            {{ $car->marka }} {{ $car->modell }}
                            <span class="text-muted float-end">{{ $car->created_at->format('Y-m-d') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
