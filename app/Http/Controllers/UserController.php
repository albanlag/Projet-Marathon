<?php

namespace App\Http\Controllers;

use App\Models\Histoire;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function personalPage($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return view('errors.404');
        }

        $histoiresTerminees = $user->terminees()->count();
        $avisPostes = $user->avis()->count();
        $histoiresEcrites = $user->mesHistoires()->count();
        $histoiresCrees = $user->mesHistoires;
        $histoiresEnCoursDeCreation = Histoire::where('user_id', $user->id)
            ->where('active', false)
            ->get();
        $histoiresEnCoursDeLecture = $user->lectures()
            ->join('histoires as h1', 'lectures.histoire_id', '=', 'h1.id')
            ->where('h1.active', true)
            ->get();


        return view('user.personal')->with(compact(
            'user',
            'histoiresTerminees',
            'avisPostes',
            'histoiresEcrites',
            'histoiresCrees',
            'histoiresEnCoursDeCreation',
            'histoiresEnCoursDeLecture'
        ));
    }

    public function updateAvatar(Request $request) {
        $user = auth()->user();
        $avatarPath = $request->file('new_avatar')->store('avatars', 'public');
        $user->update(['avatar' => basename($avatarPath)]);

        return redirect()->back()->with('success', 'Avatar mis à jour avec succès.');

    }

}
