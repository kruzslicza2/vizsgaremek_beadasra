@extends('layout')
@section('content')
<div class="container py-4">
  <h2 class="mb-4 text-center fw-bold">Fiók kezelése</h2>
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card shadow">
        <div class="card-body">
          <div class="text-center mb-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&size=128" class="rounded-circle shadow" alt="Avatar">
          </div>
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <h5 class="mb-3">Személyes adatok</h5>
            <div class="mb-4">
              <label class="form-label">Felhasználónév</label>
              <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
              @if($errors->has('username'))
                <div class="text-danger">{{ $errors->first('username') }}</div>
              @endif
            </div>
            <div class="mb-4">
              <label class="form-label">E-mail cím</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
              @if($errors->has('email'))
                <div class="text-danger">{{ $errors->first('email') }}</div>
              @endif
            </div>
            <div class="mb-4">
              <label class="form-label">Bemutatkozás</label>
              <textarea name="bio" class="form-control" rows="4">{{ old('bio', $user->bio) }}</textarea>
              @if($errors->has('bio'))
                <div class="text-danger">{{ $errors->first('bio') }}</div>
              @endif
            </div>
            <h5 class="mt-4 mb-3">Jelszó módosítása</h5>
            <div class="mb-4">
              <label class="form-label">Új jelszó</label>
              <input type="password" name="password" class="form-control">
              @if($errors->has('password'))
                <div class="text-danger">{{ $errors->first('password') }}</div>
              @endif
            </div>
            <div class="mb-4">
              <label class="form-label">Új jelszó mégegyszer</label>
              <input type="password" name="password_confirmation" class="form-control">
              @if($errors->has('password_confirmation'))
                <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
              @endif
            </div>
            <div class="text-center">
              <button class="btn btn-primary px-5 py-2">Mentés</button>
            </div>
          </form>
          <div class="text-center mt-4">
            <a href="/logout" class="btn btn-outline-danger">Kijelentkezés</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
