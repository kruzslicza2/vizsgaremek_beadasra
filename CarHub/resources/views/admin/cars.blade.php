@extends('layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Hirdetések kezelése</h2>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Felhasználó</th>
                <th>Márka</th>
                <th>Modell</th>
                <th>Ár</th>
                <th>Létrehozva</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td>{{ $car->user->username ?? 'Törölt felhasználó' }}</td>
                    <td>{{ $car->marka }}</td>
                    <td>{{ $car->modell }}</td>
                    <td>{{ number_format($car->ar, 0, '.', ' ') }} Ft</td>
                    <td>{{ $car->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline-block"
                              onsubmit="return confirm('Biztosan törölni szeretnéd ezt a hirdetést?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $cars->links() }}
    </div>
</div>
@endsection
