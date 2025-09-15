@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Autómárkák</h2>

    @auth
        @if(auth()->user()->role === 'admin')
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('brands.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Új márka
                </a>
            </div>
        @endif
    @endauth

    <div class="row">
        @foreach($brands as $brand)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    @if($brand->logo)
                        <img src="{{ asset('storage/brands/' . $brand->logo) }}"
                            alt="{{ $brand->name }}"
                            style="height:120px; object-fit:contain;" class="card-img-top p-3">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $brand->name }}</h5>
                        <p class="text-muted">{{ $brand->country }}</p>
                        @if($brand->description)
                            <p class="card-text">{{ $brand->description }}</p>
                        @endif
                                @auth
    <div class="btn-group">
        <a href="{{ route('models.index', $brand) }}" class="btn btn-sm btn-outline-info">
            <i class="fas fa-list"></i> Modellek
        </a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-edit"></i> Szerkesztés
            </a>
            <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline" onsubmit="return confirm('Biztosan törlöd a márkát?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i> Törlés
                </button>
            </form>
        @endif
    </div>
@endauth

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
