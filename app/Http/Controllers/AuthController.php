<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller{
    public function showLogin() { 
        return view('auth.login'); 
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->isAdmin ? "Admin" : "Opérateur";
            $userName = $user->nom;

            return redirect()->intended('/')
                ->with("message-success", "Heureux de vous revoir, $role $userName !");
        }


        return back()
        ->withErrors(['message-error' => 'Email ou Password incorrect !'])
        ->onlyInput("email", "password");
    }

    public function showRegister() { 
        return view('auth.register'); 
    }

    public function register(Request $request) {
        $fields = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' =>[
                'required',
                'confirmed',
                Password::min(8) 
                    ->letters()  
                    ->mixedCase()
                    ->numbers()  
                    ->symbols()  
            ],
            'admin' => 'nullable'
        ]);
        try{
            User::create([
                'nom' => $fields['nom'],
                'prenom' => $fields['prenom'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'isAdmin' => $request->admin === 'admin' 
            ]);

            return redirect()->route("users.index")->with("message-success", "Le compte est créé !");
        }
        catch(Exception $e){
            return back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.']);
        }
    }
    
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('users.login')
                ->with("message-success", "Vous avez été déconnecté.");
    }

    public function getUsers(Request $request){
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                ->orWhere('prenom', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10)->appends(['search' => $request->search]);

        return view("user.index", compact("users"));
    }

    public function editUser(User $user){
        return view("user.edit", compact("user"));
    }

    public function updateUser(Request $request, User $user) {
        
        $inputFields = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => [
                'nullable', 'confirmed', 'min:8',
                Password::min(8) 
                    ->letters()  
                    ->mixedCase()
                    ->numbers()  
                    ->symbols()
            ],
            'status' => 'required|in:admin,operateur'
        ]);

        try {
            if (!empty($inputFields['password'])) {
                $inputFields['password'] = Hash::make($inputFields['password']);
            } else {
                unset($inputFields['password']);
            }

            $inputFields['isAdmin'] = ($request->status === 'admin');

            unset($inputFields['status']);
            
            $user->update($inputFields);

            return redirect()->route("users.index")
                ->with("message-success", "Le compte a été modifié avec succès !");

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour.']);
        }
    }
    public function deleteUser(User $user) {
        try {
            $user->delete();
            return back()->with("message-success", "L'utilisateur a été supprimé !");

        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la suppression.']);
        }
    }
}