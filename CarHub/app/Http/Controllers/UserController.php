<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function RegForm()
    {
        return Auth::check() ? redirect('/') : view('reg');
    }

    public function RegButton(Request $request)
    {
        $request->validate([
            'username'              => 'required|min:5|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'password'              => ['required','confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
            'password_confirmation' => 'required',
            'bio'                   => 'required|min:10'
        ],[
            '*.required'            => 'Kötelező kitölteni!',
            'username.min'          => 'Legalább 5 karakter!',
            'username.unique'       => 'Ez a felhasználónév már foglalt!',
            'email.email'           => 'Érvényes e-mailt adj meg!',
            'email.unique'          => 'Ez az e-mail cím már foglalt!',
            'password.confirmed'    => 'A két jelszó nem egyezik!',
            'password.min'          => 'Legalább 8 karakter!',
            'password.letters'      => 'Legalább egy betű!',
            'password.mixedCase'    => 'Kis- és nagybetű!',
            'password.numbers'      => 'Legalább egy szám!',
            'bio.min'               => 'Legalább 10 karakter!'
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'bio'      => $request->bio,
            'active'   => 1
        ]);

        return redirect('/login');
    }

    public function Login()
    {
        return Auth::check() ? redirect('/') : view('login');
    }

    public function LoginButton(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ],[
        '*.required' => 'Kötelező kitölteni!'
    ]);

    $user = User::where('username', $request->username)->first();

    if (!$user) {
    return back()
        ->withErrors(['username' => 'Nincs ilyen felhasználó!'])
        ->withInput();
}

if (!Hash::check($request->password, $user->password)) {
    return back()
        ->withErrors(['password' => 'Hibás jelszó!'])
        ->withInput();
}

if ($user->active != 1) {
    return back()
        ->withErrors(['username' => 'A fiókod inaktív!'])
        ->withInput();
}

    Auth::login($user);
$request->session()->regenerate();

if ($user->role === 'admin') {
    return redirect()->route('admin.dashboard')->with('success', 'Sikeres bejelentkezés!');
}


// Sima user
return redirect()->route('cars.index')->with('success', 'Sikeres bejelentkezés!');
}

    public function Logout()
    {
        Auth::logout();
        return redirect('/cars')->with('success', 'Sikeres kijelentkezés!');
    }

    public function ListUsers(Request $request)
    {
        $query = User::query();

        // Keresés név vagy email alapján
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Szűrés aktív státusz szerint
        if ($request->filled('active')) {
            $query->where('active', $request->input('active'));
        }

        $users = $query->paginate(10);

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function EditUser($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', [
            'user' => $user
        ]);
    }


    public function sendPasswordReminder(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Nem található felhasználó ezzel az email címmel.');
        }

        try {
            Mail::raw(
                "Tisztelt {$user->username}!\n\n" .
                "Az Ön jelszava a CarHub Autókereskedés oldalán: {$user->password}\n\n" .
                "Üdvözlettel,\nAutókereskedés csapata",
                function($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Jelszóemlékeztető - CarHub Autókereskedés');
                }
            );

            return back()->with('success', 'A jelszóemlékeztetőt elküldtük az email címére.');
        } catch (\Exception $e) {
            return back()->with('error', 'Hiba történt az email küldése közben. Kérjük próbálja újra később.');
        }
    }

    public function UpdateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|min:5|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'bio'      => 'required|min:10'
        ], [
            '*.required' => 'Kötelező kitölteni!',
            'username.min' => 'Legalább 5 karakter!',
            'username.unique' => 'Ez a felhasználónév már foglalt!',
            'email.email' => 'Érvényes e-mailt adj meg!',
            'email.unique' => 'Ez az e-mail cím már foglalt!',
            'bio.min' => 'Legalább 10 karakter!'
        ]);

        $user->update([
            'username' => $request->username,
            'email'    => $request->email,
            'bio'      => $request->bio
        ]);

        return redirect()->route('users.index')->with('success', 'Felhasználó sikeresen frissítve!');
    }
    public function Profile()
    {
        $user = Auth::user();
        return view('users.profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validáció
        $request->validate([
            'username' => 'required|min:3',
            'email' => 'required|email',
            'bio' => 'nullable|max:500',
            'password' => 'nullable|min:8|confirmed'
        ]);

        // Adatok frissítése
        $user->username = $request->username;
        $user->email = $request->email;
        $user->bio = $request->bio;

        // Jelszó módosítás, ha van
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil frissítve!');
    }
}

