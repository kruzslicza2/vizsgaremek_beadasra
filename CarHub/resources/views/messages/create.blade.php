@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Új üzenet küldése</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('messages.store', $car->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Címzett</label>
                            <input type="text" class="form-control" value="{{ $car->user->username }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hirdetés</label>
                            <input type="text" class="form-control" value="{{ $car->marka }} {{ $car->modell }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Üzenet</label>
                            <textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4">Küldés</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Vissza</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
