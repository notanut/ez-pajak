<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PajakController extends Controller
{
    //
    public function importGuest(Request $request)
    {
        $userId = auth()->id();
        $kategori = $request->kategori;
        $data = $request->data;

        if ($kategori === 'pegawai_tetap') {
            \App\Models\PegawaiTetap::updateOrCreate(
                ['pengguna_id' => $userId],
                $data
            );
        } elseif ($kategori === 'pegawai_tidak_tetap') {
            \App\Models\PegawaiTidakTetap::updateOrCreate(
                ['pengguna_id' => $userId],
                $data
            );
        } elseif ($kategori === 'bukan_pegawai') {
            \App\Models\BukanPegawai::updateOrCreate(
                ['pengguna_id' => $userId],
                $data
            );
        }

        return response()->json(['success' => true]);
    }


}
