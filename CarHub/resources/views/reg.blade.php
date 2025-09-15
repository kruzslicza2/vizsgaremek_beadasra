@extends('layout')
@section('content')
<main class="container pb-2">
  <!-- Regisztrációs oldal, kezdő stílusban -->
  <h1 class="text-center display-6 py-3 fw-bold">Regisztráció</h1>
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow">
        <div class="card-body">
          <!-- Regisztrációs űrlap -->
          <form action="/reg" method="post">
            @csrf
            <!-- Felhasználónév -->
            <div class="mb-3">
              <label for="username" class="form-label">Felhasználónév:</label>
              <input type="text" name="username" id="username" class="form-control"
                     value="{{ old('username') }}" placeholder="Min. 5 karakter">
              <!-- Hibák kiírása -->
              @if($errors->has('username'))
                <p class="text-danger">{{ $errors->first('username') }}</p>
              @endif
            </div>
            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">E-mail cím:</label>
              <input type="email" name="email" id="email" class="form-control"
                     value="{{ old('email') }}" placeholder="pl.: valaki@pelda.com">
              @if($errors->has('email'))
                <p class="text-danger">{{ $errors->first('email') }}</p>
              @endif
            </div>
            <!-- Jelszó -->
            <div class="mb-3">
              <label for="password" class="form-label">Jelszó:</label>
              <input type="password" name="password" id="password" class="form-control">
              @if($errors->has('password'))
                <p class="text-danger">{{ $errors->first('password') }}</p>
              @endif
              <p class="small text-muted">A jelszó min. 8 karakter, kis- és nagybetű, szám.</p>
            </div>
            <!-- Jelszó mégegyszer -->
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Jelszó mégegyszer:</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
              @if($errors->has('password_confirmation'))
                <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
              @endif
            </div>
            <!-- Bemutatkozás -->
            <div class="mb-3">
              <label for="bio" class="form-label">Bemutatkozás:</label>
              <textarea name="bio" id="bio" class="form-control" rows="5"
                        placeholder="Írj magadról">{{ old('bio') }}</textarea>
              @if($errors->has('bio'))
                <p class="text-danger">{{ $errors->first('bio') }}</p>
              @endif
              <p class="small text-muted">Írj kicsit magadról, legalább 10 karakter</p>
            </div>
            <!-- Gomb -->
            <div class="text-center">
              <button class="btn btn-dark px-5" type="submit">Regisztrál</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
