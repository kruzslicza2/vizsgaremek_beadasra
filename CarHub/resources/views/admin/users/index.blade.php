@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Felhasználók kezelése</h2>
     <!-- Felhasználók keresés, szűrés -->
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Keresés név/email" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Összes szerepkör</option>
                    <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>Felhasználó</option>
                    <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Szűrés</button>
            </div>
        </form>

        <!-- Felhasználók táblázat -->
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Felhasználónév</th>
                    <th>Email</th>
                    <th>Szerepkör</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username ?? $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role ?? 'user' }}</td>
                    <td>
                        @if($user->role !== 'admin')
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Törlés</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->withQueryString()->links() }} <!-- Pagináció -->
    </div>
</div>
@endsection
