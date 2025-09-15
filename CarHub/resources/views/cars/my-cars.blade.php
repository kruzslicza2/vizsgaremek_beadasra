@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Hirdetéseim</h2>

    <div class="row">
        @forelse($cars as $car)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    @if($car->images->count() > 0)
                        <img src="{{ asset('storage/cars/'.$car->images->first()->path) }}"
                             class="card-img-top"
                             alt="Autó képe"
                             style="height:220px;object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->marka }} {{ $car->modell }}</h5>
                        <p class="text-success fs-5">{{ number_format($car->ar,0,',',' ') }} Ft</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-primary">
                                <i class="fas fa-eye"></i> Részletek
                            </a>
                            <div class="btn-group">
                                <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cars.destroy', $car) }}" method="POST"
                                      onsubmit="return confirm('Biztosan törölni szeretnéd ezt a hirdetést?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Még nincs hirdetésed.
                    <a href="{{ route('cars.create') }}" class="alert-link">Hozz létre egyet!</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $cars->links() }}
    </div>
</div>
@endsection
