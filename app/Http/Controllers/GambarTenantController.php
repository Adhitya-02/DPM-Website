<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GambarTenant;

class GambarTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('gambar_tenant.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd("sini");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = GambarTenant::where('tenant_id', $id)->get();
        return view('gambar_tenant.index', compact('data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gambar = GambarTenant::findOrFail($id);
        $tenant_id = $gambar->tenant_id;
        $gambar->delete();
        return redirect()->route('gambar_tenant.edit', $tenant_id)->with('success', 'Gambar berhasil dihapus');
    }

    public function tambah_gambar(Request $request)
    {
        $tenant_id = $request->tenant_id;
        $gambar = $request->file('gambar');
        $gambar_utama = $request->gambar_utama;
        $nama_gambar = $tenant_id . '_' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);
        $nama_gambar .= '.' . $gambar->getClientOriginalExtension();

        $gambar->move('gambar_tenant', $nama_gambar);
        $data = [
            'tenant_id' => $tenant_id,
            'gambar' => $nama_gambar,
            'is_gambar_utama' => $gambar_utama ?? false
        ];
        $create = GambarTenant::create($data);
        if ($create) {
            return redirect()->route('gambar_tenant.edit', $tenant_id)->with('success', 'Gambar berhasil diupload');
        } else {
            return redirect()->route('gambar_tenant.edit', $tenant_id)->with('error', 'Gambar gagal diupload');
        }
    }
}
