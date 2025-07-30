<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investasi;

class InvestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $investasis = Investasi::where('user_id', session('user_id'))
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('investasi.index', compact('investasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('investasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0'
        ]);

        try {
            $investasi = Investasi::create([
                'user_id' => session('user_id'),
                'tanggal' => $request->tanggal,
                'jenis' => $request->jenis,
                'keterangan' => $request->keterangan,
                'jumlah' => $request->jumlah
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Investasi berhasil ditambahkan',
                    'data' => $investasi
                ]);
            }

            return redirect()->route('investasi.index')->with('success', 'Investasi berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan investasi'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal menambahkan investasi']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $investasi = Investasi::where('user_id', session('user_id'))
            ->findOrFail($id);

        return view('investasi.show', compact('investasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $investasi = Investasi::where('user_id', session('user_id'))
            ->findOrFail($id);

        return response()->json($investasi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0'
        ]);

        try {
            $investasi = Investasi::where('user_id', session('user_id'))
                ->findOrFail($id);

            $investasi->update([
                'tanggal' => $request->tanggal,
                'jenis' => $request->jenis,
                'keterangan' => $request->keterangan,
                'jumlah' => $request->jumlah
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Investasi berhasil diperbarui',
                    'data' => $investasi
                ]);
            }

            return redirect()->route('investasi.index')->with('success', 'Investasi berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui investasi'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal memperbarui investasi']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $investasi = Investasi::where('user_id', session('user_id'))
                ->findOrFail($id);

            $investasi->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Investasi berhasil dihapus'
                ]);
            }

            return redirect()->route('investasi.index')->with('success', 'Investasi berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus investasi'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal menghapus investasi']);
        }
    }
}
