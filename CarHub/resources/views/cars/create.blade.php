@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Autó hirdetés feltöltése</h2>
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-body">
                    <form action="/feltoltes" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Márka választó -->
                        <div class="mb-4">
                            <label class="form-label">Márka</label>
                            <select name="marka" class="form-select" id="markaSelect" required>
                                <option value="">Válassz márkát...</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('marka') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marka')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Modell választó -->
                        <div class="mb-4">
                            <label class="form-label">Modell</label>
                            <select name="modell" class="form-select" id="modellSelect" required>
                                <option value="">Először válassz márkát...</option>
                            </select>
                            @error('modell')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Évjárat</label>
                            <input type="number" name="evjarat" class="form-control" value="{{ old('evjarat') }}" min="1900" max="{{ date('Y') }}">
                            @if($errors->has('evjarat'))
                              <div class="text-danger">{{ $errors->first('evjarat') }}</div>
                            @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Ár (Ft)</label>
                          <input type="number" name="ar" class="form-control" value="{{ old('ar') }}" min="100000">
                          @if($errors->has('ar'))
                            <div class="text-danger">{{ $errors->first('ar') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Km óra állás</label>
                          <input type="number" name="km_ora" class="form-control" value="{{ old('km_ora') }}" min="0">
                          @if($errors->has('km_ora'))
                            <div class="text-danger">{{ $errors->first('km_ora') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Teljesítmény (LE)</label>
                          <input type="number" name="teljesitmeny" class="form-control" value="{{ old('teljesitmeny') }}" min="0">
                          @if($errors->has('teljesitmeny'))
                            <div class="text-danger">{{ $errors->first('teljesitmeny') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Váltó típusa</label>
                          <select name="valto" class="form-select">
                            <option value="">Válassz...</option>
                            <option value="manuális" {{ old('valto') == 'manuális' ? 'selected' : '' }}>Manuális</option>
                            <option value="automata" {{ old('valto') == 'automata' ? 'selected' : '' }}>Automata</option>
                          </select>
                          @if($errors->has('valto'))
                            <div class="text-danger">{{ $errors->first('valto') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Szín</label>
                          <select name="szin" class="form-select">
                            <option value="">Válassz...</option>
                            @foreach(['Fekete','Fehér','Ezüst','Kék','Piros','Szürke','Zöld'] as $szin)
                              <option value="{{ $szin }}" {{ old('szin') == $szin ? 'selected' : '' }}>{{ $szin }}</option>
                            @endforeach
                          </select>
                          @if($errors->has('szin'))
                            <div class="text-danger">{{ $errors->first('szin') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Karosszéria típus</label>
                          <select name="karosszeria" class="form-select">
                            <option value="">Válassz...</option>
                            @foreach(['Sedan','Kombi','SUV','Coupe','Cabrio','Egyterű'] as $karosszeria)
                              <option value="{{ $karosszeria }}" {{ old('karosszeria') == $karosszeria ? 'selected' : '' }}>{{ $karosszeria }}</option>
                            @endforeach
                          </select>
                          @if($errors->has('karosszeria'))
                            <div class="text-danger">{{ $errors->first('karosszeria') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Extrák</label><br>
                          @foreach(['Klíma','ABS','Elektromos ablak','Ülésfűtés','Navigáció'] as $extra)
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="extrak[]" value="{{ $extra }}"
                                {{ is_array(old('extrak')) && in_array($extra, old('extrak')) ? 'checked' : '' }}>
                              <label class="form-check-label">{{ $extra }}</label>
                            </div>
                          @endforeach
                          @if($errors->has('extrak'))
                            <div class="text-danger">{{ $errors->first('extrak') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Leírás</label>
                          <textarea name="leiras" class="form-control" rows="4">{{ old('leiras') }}</textarea>
                          @if($errors->has('leiras'))
                            <div class="text-danger">{{ $errors->first('leiras') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Képek (több is választható)</label>
                          <input type="file" name="images[]" multiple class="form-control">
                          @if($errors->has('images'))
                            <div class="text-danger">{{ $errors->first('images') }}</div>
                          @endif
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Üzemanyagtípus</label>
                          <select name="uzemanyag" class="form-select" required>
                            <option value="">Válassz...</option>
                            @foreach(['Benzin','Gázolaj','Hibrid','Elektromos','Gázüzemű'] as $tipus)
                              <option value="{{ $tipus }}" {{ old('uzemanyag') == $tipus ? 'selected' : '' }}>{{ $tipus }}</option>
                            @endforeach
                          </select>
                          @if($errors->has('uzemanyag'))
                            <div class="text-danger">{{ $errors->first('uzemanyag') }}</div>
                          @endif
                        </div>
                        <div class="text-center">
                          <button class="btn btn-success px-5 py-2">Feltöltés</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const markaSelect = document.getElementById('markaSelect');
    const modellSelect = document.getElementById('modellSelect');

    markaSelect.addEventListener('change', function() {
        const brandId = this.value;

        if(brandId) {
            modellSelect.innerHTML = '<option value="">Modellek betöltése...</option>';
            modellSelect.disabled = true;

            fetch(`/api/brands/${brandId}/models`)
                .then(response => response.json())
                .then(models => {
                    modellSelect.innerHTML = '<option value="">Válassz modellt...</option>';
                    models.forEach(model => {
                        const option = new Option(model.name, model.name);
                        modellSelect.add(option);
                    });
                    modellSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Hiba történt:', error);
                    modellSelect.innerHTML = '<option value="">Hiba történt</option>';
                    modellSelect.disabled = true;
                });
        } else {
            modellSelect.innerHTML = '<option value="">Először válassz márkát...</option>';
            modellSelect.disabled = true;
        }
    });

    // Ha van már kiválasztott márka (pl. validation error után), akkor töltsük be a modelleket
    if(markaSelect.value) {
        markaSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
