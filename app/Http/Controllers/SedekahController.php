<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sedekah;

class SedekahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedekahs = Sedekah::where('user_id', session('user_id'))
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('sedekah.index', compact('sedekahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sedekah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'penerima' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255'
        ]);

        try {
            $sedekah = Sedekah::create([
                'user_id' => session('user_id'),
                'tanggal' => $request->tanggal,
                'penerima' => $request->penerima,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sedekah berhasil ditambahkan',
                    'data' => $sedekah
                ]);
            }

            return redirect()->route('sedekah.index')->with('success', 'Sedekah berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan sedekah'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal menambahkan sedekah']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sedekah = Sedekah::where('user_id', session('user_id'))
            ->findOrFail($id);

        return view('sedekah.show', compact('sedekah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sedekah = Sedekah::where('user_id', session('user_id'))
            ->findOrFail($id);

        return response()->json($sedekah);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'penerima' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255'
        ]);

        try {
            $sedekah = Sedekah::where('user_id', session('user_id'))
                ->findOrFail($id);

            $sedekah->update([
                'tanggal' => $request->tanggal,
                'penerima' => $request->penerima,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sedekah berhasil diperbarui',
                    'data' => $sedekah
                ]);
            }

            return redirect()->route('sedekah.index')->with('success', 'Sedekah berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui sedekah'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal memperbarui sedekah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sedekah = Sedekah::where('user_id', session('user_id'))
                ->findOrFail($id);

            $sedekah->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sedekah berhasil dihapus'
                ]);
            }

            return redirect()->route('sedekah.index')->with('success', 'Sedekah berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus sedekah'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal menghapus sedekah']);
        }
    }
}
