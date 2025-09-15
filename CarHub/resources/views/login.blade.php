@extends('layout')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">
                        <i class="fas fa-car text-primary me-2"></i>
                        CarHub Bejelentkezés
                    </h3>
                   <form action="/login" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Felhasználónév</label>
                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror"
                            required
                        >
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jelszó</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($errors->has('fail'))
                        <div class="alert alert-danger">
                            {{ $errors->first('fail') }}
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Belépek</button>
                        <button type="button" class="btn btn-link"
                                data-bs-toggle="modal"
                data-bs-target="#passwordReminder">
                            Jelszóemlékeztető kérése
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jelszóemlékeztető Modal -->
<div class="modal fade" id="passwordReminder" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jelszóemlékeztető kérése</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('password.remind') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email cím</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                    <button type="submit" class="btn btn-primary">Küldés</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
