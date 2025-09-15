@extends('layout')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <!-- Képek -->
                @if($car->images && count($car->images) > 0)
    <div id="carImagesCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($car->images as $key => $image)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <a href="{{ asset('storage/cars/' . $image->path) }}" target="_blank" title="Kattints a nagyobb képért!">
                        <img src="{{ asset('storage/cars/' . $image->path) }}"
                             class="d-block w-100"
                             style="height:350px; object-fit:cover; cursor:pointer;"
                             alt="Autó kép">
                    </a>
                </div>
            @endforeach
        </div>
        @if(count($car->images) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#carImagesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" style="width:2rem;height:2rem;background-size:80% 80%;background-color:rgba(0,0,0,0.3);border-radius:50%;"></span>
                <span class="visually-hidden">Előző</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carImagesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" style="width:2rem;height:2rem;background-size:80% 80%;background-color:rgba(0,0,0,0.3);border-radius:50%;"></span>
                <span class="visually-hidden">Következő</span>
            </button>
        @endif
    </div>
@endif

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h2 class="card-title fw-bold mb-0">{{ $car->marka }} {{ $car->modell }}</h2>

                        <!-- Kedvencek gomb -->
                        @auth
                            <form action="{{ route('favorites.toggle', $car) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    @if(Auth::user()->favorites->contains('car_id', $car->id))
                                        <i class="fas fa-heart"></i> Kedvencekből törlés
                                    @else
                                        <i class="far fa-heart"></i> Kedvencekhez adás
                                    @endif
                                </button>
                            </form>
                        @endauth
                    </div>

                    <div class="row mb-2">
                        <div class="col-6"><strong>Évjárat:</strong> {{ $car->evjarat }}</div>
                        <div class="col-6"><strong>Üzemanyag:</strong> {{ ucfirst($car->uzemanyag) }}</div>
                    </div>
                    <div class="mb-3">
                        <span class="fs-4 text-success fw-bold">{{ number_format($car->ar,0,',',' ') }} Ft</span>
                    </div>
                    <div class="mb-3">
                        <strong>Leírás:</strong>
                        <p>{{ $car->leiras }}</p>
                    </div>
                    @if($car->extrak)
                        <div class="mb-2">
                            <strong>Extrák:</strong>
                            <span>{{ $car->extrak }}</span>
                        </div>
                    @endif
                    <ul class="list-unstyled mb-2">
                        <li><strong>Kilométeróra:</strong> {{ $car->km_ora }}</li>
                        <li><strong>Teljesítmény:</strong> {{ $car->teljesitmeny }} LE</li>
                        <li><strong>Váltó:</strong> {{ $car->valto }}</li>
                        <li><strong>Szín:</strong> {{ $car->szin }}</li>
                        <li><strong>Karosszéria:</strong> {{ $car->karosszeria }}</li>
                    </ul>
                    <div class="text-muted small">
    <i class="fas fa-user"></i> Hirdető: {{ $car->user->username ?? 'Ismeretlen' }}
    <br>
    <a href="{{ route('user.cars', $car->user_id) }}" class="text-primary">
        <i class="fas fa-list me-1"></i>Hirdető összes hirdetése
    </a>
</div>

                    <!-- Üzenetküldés -->
                    @auth
                        @if(Auth::id() != $car->user_id)
                            <div class="mt-4">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#messageModal">
                                    <i class="fas fa-envelope"></i> Üzenet küldése
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info mt-4">
                            <a href="{{ route('login') }}">Jelentkezz be</a> az üzenetküldéshez!
                        </div>
                    @endauth
                </div>
            </div>

<div class="d-flex gap-2">
    <a href="{{ route('cars.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Vissza a listához
    </a>
    @if(Auth::id() == $car->user_id)
        <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Hirdetés szerkesztése
        </a>
    @endif
    @if(Auth::check() && (Auth::id() == $car->user_id || Auth::user()->role === 'admin'))
<form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline"
      onsubmit="return confirm('Biztosan törölni szeretnéd ezt a hirdetést?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
        <i class="fas fa-trash"></i> Hirdetés törlése
    </button>
</form>
@endif
    </div>
        </div>
    </div>
</div>

<!-- Üzenetküldő Modal -->
@auth
    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Üzenet küldése</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('messages.store', $car) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Üzenet szövege</label>
                            <textarea name="message" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                        <button type="submit" class="btn btn-primary">Küldés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endauth
@endsection
