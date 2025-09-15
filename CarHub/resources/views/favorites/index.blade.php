@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Kedvenc hirdetések</h2>

    <div class="row">
        @forelse($favorites as $favorite)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    @if($favorite->car->kep)
                        <img src="{{ asset('storage/cars/'.$favorite->car->kep) }}" class="card-img-top" alt="Autó képe" style="height:220px;object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $favorite->car->marka }} {{ $favorite->car->modell }}</h5>
                        <p class="text-success fs-5">{{ number_format($favorite->car->ar,0,',',' ') }} Ft</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('cars.show', $favorite->car->id) }}" class="btn btn-primary">Részletek</a>
                            <form action="{{ route('favorites.toggle', $favorite->car->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-heart-broken"></i> Törlés
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Még nincs kedvenc hirdetésed!
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
