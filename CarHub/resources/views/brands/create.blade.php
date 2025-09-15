@extends('layout')
@section('content')
@php
$orszagok = [
    "Afganisztán", "Albánia", "Algéria", "Amerikai Egyesült Államok", "Andorra", "Angola", "Antigua és Barbuda",
    "Argentína", "Ausztrália", "Ausztria", "Azerbajdzsán", "Bahama-szigetek", "Bahrein", "Banglades",
    "Barbados", "Belgium", "Belize", "Benin", "Bhután", "Bissau-Guinea", "Bolívia", "Bosznia-Hercegovina",
    "Botswana", "Brazília", "Brunei", "Bulgária", "Burkina Faso", "Burundi", "Chile", "Ciprus", "Costa Rica",
    "Csád", "Csehország", "Dánia", "Dél-Afrika", "Dél-Korea", "Dominikai Köztársaság", "Dzsibuti", "Ecuador",
    "Egyenlítői-Guinea", "Egyesült Arab Emírségek", "Egyiptom", "Elefántcsontpart", "Eritrea", "Észtország",
    "Etiópia", "Fehéroroszország", "Fidzsi-szigetek", "Finnország", "Franciaország", "Fülöp-szigetek", "Gabon",
    "Gambia", "Ghána", "Görögország", "Grúzia", "Guatemala", "Guinea", "Guyana", "Haiti", "Hollandia", "Honduras",
    "Horvátország", "India", "Indonézia", "Irak", "Irán", "Írország", "Izland", "Izrael", "Jamaica", "Japán",
    "Jemen", "Jordánia", "Kambodzsa", "Kamerun", "Kanada", "Katar", "Kazahsztán", "Kelet-Timor", "Kenya",
    "Kína", "Kirgizisztán", "Kiribati", "Kolumbia", "Kongói Demokratikus Köztársaság", "Kongói Köztársaság",
    "Közép-afrikai Köztársaság", "Kuba", "Kuvait", "Laosz", "Lengyelország", "Lesotho", "Lettország", "Libanon",
    "Libéria", "Líbia", "Liechtenstein", "Litvánia", "Luxemburg", "Macedónia", "Madagaszkár", "Magyarország",
    "Malajzia", "Malawi", "Maldív-szigetek", "Mali", "Málta", "Marokkó", "Mauritánia", "Mexikó", "Mianmar",
    "Moldova", "Mongólia", "Montenegró", "Mozambik", "Namíbia", "Németország", "Nepál", "Nicaragua", "Niger",
    "Nigéria", "Norvégia", "Olaszország", "Omán", "Oroszország", "Örményország", "Pakisztán", "Panama",
    "Pápua Új-Guinea", "Paraguay", "Peru", "Portugália", "Románia", "Ruanda", "Saint Kitts és Nevis",
    "Saint Lucia", "Saint Vincent", "Salamon-szigetek", "Salvador", "San Marino", "São Tomé és Príncipe",
    "Seychelle-szigetek", "Sierra Leone", "Spanyolország", "Sri Lanka", "Suriname", "Svájc", "Svédország",
    "Szamoa", "Szaúd-Arábia", "Szenegál", "Szerbia", "Szingapúr", "Szíria", "Szlovákia", "Szlovénia",
    "Szomália", "Szudán", "Szváziföld", "Tádzsikisztán", "Tanzánia", "Thaiföld", "Togo", "Tonga",
    "Törökország", "Trinidad és Tobago", "Tunézia", "Uganda", "Új-Zéland", "Ukrajna", "Uruguay", "Üzbegisztán",
    "Vanuatu", "Vatikán", "Venezuela", "Vietnam", "Zambia", "Zimbabwe"
];
sort($orszagok);
@endphp
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Új márka hozzáadása</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Márkanév</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            @if($errors->has('name'))
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
    <label class="form-label">Származási ország</label>
    <select name="country" class="form-select" required>
        <option value="">Válassz országot...</option>
        @foreach($orszagok as $orszag)
            <option value="{{ $orszag }}" {{ old('country') == $orszag ? 'selected' : '' }}>
                {{ $orszag }}
            </option>
        @endforeach
    </select>
    @error('country')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
                        <div class="mb-3">
                            <label class="form-label">Logó</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            @error('logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Leírás</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4">Mentés</button>
                            <a href="{{ route('brands.index') }}" class="btn btn-secondary px-4">Vissza</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
