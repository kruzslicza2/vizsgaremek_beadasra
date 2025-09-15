@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Hirdetés szerkesztése</h2>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Jelenlegi képek megjelenítése -->
                    @if($car->images && count($car->images) > 0)
                        <div class="mb-4">
                            <h5>Jelenlegi képek:</h5>
                            <div class="row">
                                @foreach($car->images as $image)
                                    <div class="col-md-4 mb-3 position-relative">
                                        <img src="{{ asset('storage/cars/'.$image->path) }}"
                                             class="img-thumbnail"
                                             alt="Car image">
                                        @if($image->path !== $car->kep)
                                            <form action="{{ route('cars.deleteImage', [$car->id, $image->id]) }}"
                                                  method="POST"
                                                  class="position-absolute top-0 end-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Biztosan törölni szeretnéd ezt a képet?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-primary position-absolute top-0 start-0">Fő kép</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">További képek feltöltése</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Márka</label>
                            <input type="text" name="marka" class="form-control" value="{{ old('marka', $car->marka) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Modell</label>
                            <input type="text" name="modell" class="form-control" value="{{ old('modell', $car->modell) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Évjárat</label>
                            <input type="number" name="evjarat" class="form-control" value="{{ old('evjarat', $car->evjarat) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ár (Ft)</label>
                            <input type="number" name="ar" class="form-control" value="{{ old('ar', $car->ar) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kilométeróra állás</label>
                            <input type="number" name="km_ora" class="form-control" value="{{ old('km_ora', $car->km_ora) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teljesítmény (LE)</label>
                            <input type="number" name="teljesitmeny" class="form-control" value="{{ old('teljesitmeny', $car->teljesitmeny) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Üzemanyag</label>
                            <select name="uzemanyag" class="form-select" required>
                                @foreach(['Benzin','Gázolaj','Hibrid','Elektromos','Gázüzemű'] as $tipus)
                                    <option value="{{ $tipus }}" {{ old('uzemanyag', $car->uzemanyag) == $tipus ? 'selected' : '' }}>
                                        {{ $tipus }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Váltó</label>
                            <select name="valto" class="form-select" required>
                                <option value="manuális" {{ old('valto', $car->valto) == 'manuális' ? 'selected' : '' }}>Manuális</option>
                                <option value="automata" {{ old('valto', $car->valto) == 'automata' ? 'selected' : '' }}>Automata</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Szín</label>
                            <select name="szin" class="form-select" required>
                                @foreach(['Fekete','Fehér','Ezüst','Kék','Piros','Szürke','Zöld'] as $szin)
                                    <option value="{{ $szin }}" {{ old('szin', $car->szin) == $szin ? 'selected' : '' }}>
                                        {{ $szin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Karosszéria</label>
                            <select name="karosszeria" class="form-select" required>
                                @foreach(['Sedan','Kombi','SUV','Coupe','Cabrio','Egyterű'] as $tipus)
                                    <option value="{{ $tipus }}" {{ old('karosszeria', $car->karosszeria) == $tipus ? 'selected' : '' }}>
                                        {{ $tipus }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Extrák</label>
                            @php $carExtras = explode(',', $car->extrak); @endphp
                            @foreach(['Klíma','ABS','Elektromos ablak','Ülésfűtés','Navigáció'] as $extra)
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="extrak[]"
                                           value="{{ $extra }}"
                                           class="form-check-input"
                                           {{ in_array($extra, $carExtras) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $extra }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Leírás</label>
                            <textarea name="leiras" class="form-control" rows="4" required>{{ old('leiras', $car->leiras) }}</textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Mentés</button>
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-secondary">Vissza</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
