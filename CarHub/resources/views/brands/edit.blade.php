@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Márka szerkesztése</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Márka neve</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Származási ország</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $brand->country) }}" required>
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jelenlegi logó</label>
                            @if($brand->logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/brands/'.$brand->logo) }}" alt="Current logo" style="height:100px;">
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <small class="text-muted">Csak akkor tölts fel új képet, ha cserélni szeretnéd</small>
                            @error('logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Leírás</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $brand->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="active" class="form-check-input" value="1" {{ $brand->active ? 'checked' : '' }}>
                                <label class="form-check-label">Aktív</label>
                            </div>
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
