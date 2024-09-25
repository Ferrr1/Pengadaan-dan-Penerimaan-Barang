<?php

namespace App\Http\Controllers;

use App\Models\Rekanan;
use App\Http\Requests\StoreRekananRequest;
use App\Http\Requests\UpdateRekananRequest;
use Illuminate\Http\Request;

class RekananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rekanan::query();

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $perStatus = $request->input("perStatus", 'all');
        $search = $request->input('search', '');
        $lastKodeRekanan = Rekanan::orderBy('kode_rekanan', 'desc')->first();
        $nextKodeRekanan = $lastKodeRekanan ? str_pad((int)$lastKodeRekanan->kode_rekanan + 1, 6, '0', STR_PAD_LEFT) : '000001';

        // $searchableColumns = ['kode_rekanan', 'nama_rekanan'];
        if ($search) {
            $query->where("nama_rekanan", "like", "%" . $search . "%")
                ->orWhere("kode_rekanan", "like", "%" . $search . "%");
        }

        if ($perStatus !== 'all') {
            $query->where('status_rekanan', $perStatus);
        }

        if ($perPage === 'all') {

            $rekanans = $query->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $rekanans = $query->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }
        return view('pages.rekanan.index', compact('rekanans', 'sortField', 'sortDirection', 'perPage', 'perStatus', 'nextKodeRekanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRekananRequest $request)
    {
        $validation = $request->validate([
            'nama_rekanan' => 'required',
            'alamat_rekanan' => 'required',
            'telepon_rekanan' => 'required|numeric|max_digits:12',
            'email_rekanan' => 'required|email',
            'status_rekanan' => 'required|string',
            'tgl_bergabung' => 'required|date',
            'tgl_akhir' => 'required|date',
            'project_id' => 'nullable',
        ]);
        $lastKodeRekanan = Rekanan::orderBy('kode_rekanan', 'desc')->first();
        $nextKodeRekanan = $lastKodeRekanan ? str_pad((int)$lastKodeRekanan->kode_rekanan + 1, 6, '0', STR_PAD_LEFT) : '000001';

        // Add the next kode_rekanan to the validated data
        $validation['kode_rekanan'] = $nextKodeRekanan;
        // dd($validation);
        Rekanan::create($validation);

        return redirect()->route('suppliers.index')->with([
            'success' => 'Rekanan created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rekanan $rekanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rekanan $rekanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRekananRequest $request, $id)
    {
        $rekanan = Rekanan::findOrFail($id);
        $validation = $request->validate([
            'nama_rekanan' => 'required',
            'alamat_rekanan' => 'required',
            'telepon_rekanan' => 'required|numeric|max_digits:12',
            'email_rekanan' => 'required|email',
            'status_rekanan' => 'required|string',
            'tgl_bergabung' => 'required|date',
            'tgl_akhir' => 'required|date',
            'project_id' => 'nullable',
        ]);
        $rekanan->update($validation);

        return redirect()->route('suppliers.index')->with([
            'success' => 'Rekanan updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekanan = Rekanan::findOrFail($id);
        $rekanan->delete();
        return redirect()->route('suppliers.index')->with('success', 'Rekanan deleted successfully');
    }
}
