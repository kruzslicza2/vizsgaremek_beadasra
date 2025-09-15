@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">{{ $brand->name }} modelljei</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('models.store', $brand->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Új modell neve" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Hozzáadás
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
            </div>

            <div class="list-group">
    @foreach($brand->models as $model)
        <div class="list-group-item d-flex justify-content-between align-items-center">
            {{ $model->name }}

            @if(auth()->check() && auth()->user()->role === 'admin')
                <form action="{{ route('models.destroy', [$brand->id, $model->id]) }}"
                      method="POST"
                      onsubmit="return confirm('Biztosan törölni szeretnéd ezt a modellt?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @endif
        </div>
    @endforeach
</div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Vissza a márkákhoz
        </a>
    </div>
</div>
@endsection
