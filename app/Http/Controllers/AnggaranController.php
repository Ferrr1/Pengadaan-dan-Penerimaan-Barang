<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Http\Requests\StoreAnggaranRequest;
use App\Http\Requests\UpdateAnggaranRequest;
use App\Models\Kel_Anggaran;
use App\Models\Produk;
use App\Models\Project;
use App\Models\Satuan;
use App\Models\SubAnggaran;
use Illuminate\Http\Request;
// use Flasher\Notyf\Prime\NotyfInterface;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryAnggaran = Anggaran::query()->with('project');
        $queryProject = Project::query();
        $queryKelAnggaran = Kel_Anggaran::query();
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $search = $request->input('search', '');
        // $searchableColumns = ['kode_anggaran', 'nama_anggaran'];
        if ($search) {
            $queryAnggaran->where("kode_project", "like", "%" . $search . "%")
                ->orWhere("nama_project", "like", "%" . $search . "%");
        }

        if ($perPage === 'all') {

            $anggarans = $queryAnggaran->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $projects = $queryProject->orderBy($sortField, $sortDirection)->get();
            $kel_anggarans = $queryKelAnggaran->orderBy($sortField, $sortDirection)->get();
            $anggarans = $queryAnggaran->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }
        return view('pages.anggaran.index', compact('anggarans', 'projects', 'kel_anggarans', 'sortField', 'sortDirection', 'perPage'));
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
    public function store(StoreAnggaranRequest $request)
    {
        try {
            $project = Project::where('id', $request->input('project_id'))->firstOrFail();
            $existingAnggaran = Anggaran::where('project_id', $project->id)->first();
            if ($existingAnggaran) {
                throw new \Exception('Sudah ada anggaran untuk proyek ini.');
            }
            $validation =  $request->all();
            Anggaran::create($validation);

            return redirect()->route('anggarans.index')->with([
                notyf()->position('y', 'top')->success('Anggaran berhasil dibuat'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Anggaran gagal dibuat. Silakan coba lagi.' . ' ' . $e->getMessage())]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Anggaran $anggaran)
    {
        $queryAnggaran = $anggaran->subAnggarans();
        $queryProduk = Produk::query();
        $queryKelAnggaran = Kel_Anggaran::query();
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $search = $request->input('search', '');
        $perPage = $request->input("perPage", 10);
        $lastNoDetailAnggaran = SubAnggaran::orderBy('no_detail', 'desc')->first();
        $nextNoDetailAnggaran = $lastNoDetailAnggaran ? str_pad((int)$lastNoDetailAnggaran->no_detail + 1, 4, '0', STR_PAD_LEFT) : '0001';
        $total_harga_satuan = $queryAnggaran->sum('harga_anggaran');
        $total_jumlah_harga = $queryAnggaran->sum('total_anggaran');
        if ($search) {
            $queryAnggaran->where("no_detail", "like", "%" . $search . "%")
                ->orWhere("nama_anggaran", "like", "%" . $search . "%");
        }

        if ($perPage === 'all') {

            $subAnggarans = $queryAnggaran->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;
        }
        $projects = $anggaran->project;
        $kel_anggarans = $queryKelAnggaran->orderBy($sortField, $sortDirection)->get();
        $produks = $queryProduk->orderBy($sortField, $sortDirection)->get();
        $subAnggarans = $queryAnggaran->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);
        return view("pages.anggaran.show_sub_anggaran")->with([
            "anggaran" => $anggaran,
            "subAnggarans" => $subAnggarans,
            "projects" => $projects,
            "kel_anggarans" => $kel_anggarans,
            "sortField" => $sortField,
            "sortDirection" => $sortDirection,
            "perPage" => $perPage,
            "search" => $search,
            "total_jumlah_harga" => $total_jumlah_harga,
            "total_harga_satuan" => $total_harga_satuan,
            "produks" => $produks,
            "nextNoDetailAnggaran" => $nextNoDetailAnggaran
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggaran $anggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnggaranRequest $request, Anggaran $anggaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggaran $anggaran)
    {
        // $anggaran = Anggaran::findOrFail($id);
        try {
            $anggaran->delete();
            return redirect()->route('anggarans.index')->with([
                notyf()->position('y', 'top')->success('Anggaran berhasil di hapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Anggaran gagal di hapus. Silakan coba lagi.')]);
        }
    }
}
