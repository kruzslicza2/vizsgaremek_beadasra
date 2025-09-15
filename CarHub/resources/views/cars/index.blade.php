@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Hirdetések</h2>

    <!-- Szűrő form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('cars.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Márka választó legördülő lista -->
                    <div class="col-md-3">
    <label class="form-label">Márka</label>
    <select name="marka" class="form-select">
        <option value="">Összes márka</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->name }}"
                    data-brand-id="{{ $brand->id }}"
                    {{ request('marka') == $brand->name ? 'selected' : '' }}>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
</div>

                    <!-- Többi szűrő mező marad változatlan -->
                    <div class="col-md-3">
                        <label class="form-label">Modell</label>
                        <select name="modell" class="form-select" id="modellSelect">
        <option value="">Válassz modellt...</option>
    </select>
                    </div>

                    <div class="col-md-3">
    <label class="form-label">Évjárat -tól</label>
    <select name="evjarat_from" class="form-select">
        <option value="">Mindegy</option>
        @for($year = 1900; $year <= date('Y'); $year++)
            <option value="{{ $year }}" {{ request('evjarat_from') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor
    </select>
</div>

<div class="col-md-3">
    <label class="form-label">Évjárat -ig</label>
    <select name="evjarat_to" class="form-select">
        <option value="">Mindegy</option>
        @for($year = date('Y'); $year >= 1900; $year--)
            <option value="{{ $year }}" {{ request('evjarat_to') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor
    </select>
</div>

                    <!-- ...további meglévő szűrők... -->

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Keresés
                        </button>
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo me-2"></i>Szűrők törlése
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hirdetések listája -->
    <div class="row">
        @forelse($cars as $car)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100" style="transition:box-shadow 0.2s;">
                    @if($car->kep)
                        <img src="{{ asset('storage/cars/'.$car->kep) }}" class="card-img-top" alt="Autó képe" style="height:220px;object-fit:cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:220px;">
                            <span>Nincs kép</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $car->marka }} {{ $car->modell }}</h5>
                        <ul class="list-unstyled mb-2">
                            <li><strong>Évjárat:</strong> {{ $car->evjarat }}</li>
                            <li><strong>Üzemanyag:</strong> {{ ucfirst($car->uzemanyag) }}</li>
                            <li><strong>Ár:</strong> <span class="text-success fs-5">{{ number_format($car->ar,0,',',' ') }} Ft</span></li>
                        </ul>
                        <a href="{{ route('cars.show',$car->id) }}" class="btn btn-outline-primary w-100">Részletek</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Nincs a keresési feltételeknek megfelelő hirdetés.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Lapozó -->
    <div class="d-flex justify-content-center mt-4">
        {{ $cars->links() }}
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const markaSelect = document.querySelector('select[name="marka"]');
    const modellSelect = document.getElementById('modellSelect');

    markaSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const brandId = selectedOption.dataset.brandId;

        if(brandId) {
            modellSelect.innerHTML = '<option value="">Modellek betöltése...</option>';
            modellSelect.disabled = true;

            fetch(`/api/brands/${brandId}/models`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(models => {
                    if (Array.isArray(models)) {
                        modellSelect.innerHTML = '<option value="">Válassz modellt...</option>';
                        models.forEach(model => {
                            const option = new Option(model.name, model.name);
                            modellSelect.add(option);
                        });
                    } else {
                        throw new Error('Invalid response format');
                    }
                    modellSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modellSelect.innerHTML = '<option value="">Nincs elérhető modell</option>';
                    modellSelect.disabled = true;
                });
        } else {
            modellSelect.innerHTML = '<option value="">Először válassz márkát...</option>';
            modellSelect.disabled = true;
        }
    });
});
</script>
@endpush
@endsection
