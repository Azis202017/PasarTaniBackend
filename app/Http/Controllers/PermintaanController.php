<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Status;
use App\Models\Permintaan;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $statusArg = $request->query('status');

        $loggedInUserId = auth()->user()->id;

        $permintaans = Permintaan::with(['petani', 'koperasi', 'status'])
            ->where('id_petani', $loggedInUserId);

        if ($statusArg) {
            $permintaans->whereHas('status', function ($query) use ($statusArg) {
                $query->where('status', $statusArg);
            });
        }

        $permintaans = $permintaans->get();
        $status = Status::all();
        $jumlahDiterima = Permintaan::where('id_petani', $loggedInUserId)
            ->whereHas('status', function ($query) {
                $query->where('status', 'diterima');
            })
            ->count();

        $jumlahDiproses = Permintaan::where('id_petani', $loggedInUserId)
            ->whereHas('status', function ($query) {
                $query->where('status', 'diproses');
            })
            ->count();


        return response()->json([
            'data' => $permintaans,
            'jumlahDiterima' => $jumlahDiterima,
            'jumlahProses' => $jumlahDiproses
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_petani' => 'required',
                'id_koperasi' => 'required',
                'kategori' => 'required',
                'harga' => 'required',
                'berat' => 'required',
                'durasi_tahan' => 'required',
                'foto' => 'required|image|mimes:jpg,png,jpeg,gif'
            ]);
            $image = $request->file('foto')->store('image', 'public');



            $postData = Permintaan::create([
                'id_petani' => $request->id_petani,
                'id_koperasi' => $request->id_koperasi,
                'name' => $request->name,
                'description' => $request->description,
                'jumlah' => $request->jumlah,
                'kategori' => $request->kategori,
                'harga' => $request->harga,
                'berat' => $request->berat,
                'durasi_tahan' => $request->durasi_tahan,
                'foto' => asset('/storage/' . $image),

            ]);

            return response()->json([
                'message' => 'success',
                'data' => $postData,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'statusCode' => 500,
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $permintaan = Permintaan::find($id);

            if (!$permintaan) {
                return response()->json([
                    'message' => 'Permintaan tidak ditemukan',
                ], 404);
            }

            $permintaan->delete();

            return response()->json([
                'message' => 'Permintaan berhasil dihapus',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'ada yang salah',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function edit(Request $request, $id)
    {
        try {
            $permintaan = Permintaan::find($id);

            if (!$permintaan) {
                return response()->json([
                    'message' => 'Permintaan tidak ditemukan',
                ], 404);
            }
            if ($request->hasFile('foto')) {
                $request->validate([
                    'foto' => 'image|mimes:jpg,png,jpeg,gif'
                ]);

                // Simpan file gambar yang baru
                $image = $request->file('foto')->store('image', 'public');
                $permintaan->foto = asset('/storage/' . $image);
            }
            $permintaan->name = $request->name;
            $permintaan->description = $request->description;
            $permintaan->kategori = $request->kategori;
            $permintaan->harga = $request->harga;
            $permintaan->berat = $request->berat;
            $permintaan->jumlah = $request->jumlah;
            $permintaan->durasi_tahan = $request->durasi_tahan;
            $permintaan->save();







            return response()->json([
                'message' => 'Permintaan berhasil diubah',
                'data' => $permintaan,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'ada yang salah',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function detailPermintaan($id)
    {
        $permintaans = Permintaan::with(['petani', 'koperasi', 'status'])
            ->find($id);
        return response()->json([
            'data' => $permintaans,

        ]);
    }
}
