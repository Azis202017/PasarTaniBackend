<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Permintaan;
use Exception;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function store(Request $request)
    {
        try {
            $store = Status::create([
                'id_permintaan' => $request->id_permintaan,
                'keterangan' => $request->keterangan,
                'tgl_perubahan' => $request->tgl_perubahan,
                'status' => $request->status,
            ]);
            return response()->json([
                'data' => $store,
                'message' => 'Berhasil memasukkan data',
                'status' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Ada sesuatu yang salah',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
  
    public function destroy($id)
    {
        try {
            $status = Status::find($id);
            if(!$status) {
                return response()->json([
                    'message' => 'Status tidak ditemukan',
                ], 404);
            }
            $status->delete();
            return response()->json([
                'message' => 'Status berhasil dihapus',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Ada kesalahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
