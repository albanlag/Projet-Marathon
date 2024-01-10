<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $successMessage = [
            'Nom: ' . $request->input('nom'),
            'Prénom: ' . $request->input('prenom'),
            'Email: ' . $request->input('email'),
            'Message: ' . $request->input('message'),
        ];

        return redirect()->route('contact.submit')->with('success', $successMessage);
    }
}
