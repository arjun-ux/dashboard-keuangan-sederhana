<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::where('user_id', session('user_id'))
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pendapatan,pengeluaran',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0'
        ]);

        try {
            $transaksi = Transaksi::create([
                'user_id' => session('user_id'),
                'tanggal' => $request->tanggal,
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
                'jumlah' => $request->jumlah
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil ditambahkan',
                    'data' => $transaksi
                ]);
            }

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan transaksi'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal menambahkan transaksi']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::where('user_id', session('user_id'))
            ->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaksi = Transaksi::where('user_id', session('user_id'))
            ->findOrFail($id);

        return response()->json($transaksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pendapatan,pengeluaran',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0'
        ]);

        try {
            $transaksi = Transaksi::where('user_id', session('user_id'))
                ->findOrFail($id);

            $transaksi->update([
                'tanggal' => $request->tanggal,
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
                'jumlah' => $request->jumlah
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil diperbarui',
                    'data' => $transaksi
                ]);
            }

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui transaksi'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal memperbarui transaksi']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $transaksi = Transaksi::where('user_id', session('user_id'))
                ->findOrFail($id);

            $transaksi->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil dihapus'
                ]);
            }

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus transaksi'
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal menghapus transaksi']);
        }
    }
}
