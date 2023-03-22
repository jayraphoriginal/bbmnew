<?php

namespace App\Http\Controllers;

use App\Models\AbsensiExpo;
use App\Models\Invitation;
use Illuminate\Http\Request;

class AbsensiExpoController extends Controller
{
    public function absen($id){
        $absen = new AbsensiExpo();
        $absen['invitation_id'] = $id;
        $absen->save();

        $data = Invitation::find($id);

        return view('expo.success',[
            'data' => $data
        ]);
    }
}
