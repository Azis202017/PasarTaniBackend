<?php

namespace App\Http\Controllers;

use App\Models\Uang;
use Illuminate\Http\Request;
use App\Models\HistoryPenarikan;
use App\Models\HistoryPengiriman;

class UangController extends Controller
{
    public function index()
    {
        $loggedInUserId = auth()->user()->id;


        $uang  = Uang::with(['user', 'history_penarikan', 'history_pemasukan'])->where('id_petani', $loggedInUserId)
            ->get();

        return response()->json($uang);
    }
    public function tarikUang(Request $request, $id)
    {

        $nominalPenarikan = $request->input('nominal_penarikan');

        $uang = Uang::find($id);

        if (!$uang) {
            return response()->json(['message' => 'Uang tidak ditemukan'], 404);
        }

        if ($uang->saldo < $nominalPenarikan) {
            return response()->json(['message' => 'Saldo tidak mencukupi'], 400);
        }

        $historyPenarikan = new HistoryPenarikan();
        $historyPenarikan->id_uang = $uang->id;
        $historyPenarikan->nominal_penarikan = $nominalPenarikan;
        $historyPenarikan->waktu_penarikan = now();
        $historyPenarikan->save();

        // Update saldo
        $uang->updateSaldoPenarikan($nominalPenarikan);

        return response()->json(['message' => 'Penarikan berhasil']);
    }
    public function kirimPemasukan(Request $request, $id)
    {

        $nominalPemasukan = $request->input('nominal_pemasukan');

        $uang = Uang::find($id);

        if (!$uang) {
            return response()->json(['message' => 'Uang tidak ditemukan'], 404);
        }

        // Buat history pemasukan
        $historyPemasukan = new HistoryPengiriman();
        $historyPemasukan->id_uang = $uang->id;
        $historyPemasukan->nominal_pengiriman = $nominalPemasukan;
        $historyPemasukan->waktu_pengiriman = now();
        $historyPemasukan->save();

        $uang->updateSaldoPemasukan($nominalPemasukan);

        return response()->json(['message' => 'Pemasukan berhasil']);
    }
}

