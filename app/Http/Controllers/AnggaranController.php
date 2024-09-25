<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Http\Requests\StoreAnggaranRequest;
use App\Http\Requests\UpdateAnggaranRequest;
use App\Models\Project;
use App\Models\Satuan;
use App\Models\SubAnggaran;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryAnggaran = Anggaran::query();
        $queryProject = Project::query();
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
            $anggarans = $queryAnggaran->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }
        return view('pages.anggaran.index', compact('anggarans', 'projects', 'sortField', 'sortDirection', 'perPage'));
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
        $validation = $request->validate([
            'kode_anggaran_project' => 'required|exists:projects,kode_project',
            'nama_anggaran_project' => 'required|exists:projects,nama_project',
        ]);
        $project = Project::where('kode_project', $validation['kode_anggaran_project'])->firstOrFail();
        $validation['project_id'] =  $project->id;
        // dd($validation);
        Anggaran::create($validation);

        return redirect()->route('anggarans.index')->with([
            'success' => 'Anggaran created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Anggaran $anggaran)
    {
        $queryAnggaran = $anggaran->subAnggarans();
        $querySatuan = Satuan::query();
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $search = $request->input('search', '');
        $perPage = $request->input("perPage", 10);
        $lastKodeAnggaran = SubAnggaran::orderBy('kode_anggaran', 'desc')->first();
        $lastNoDetailAnggaran = SubAnggaran::orderBy('no_detail', 'desc')->first();
        $nextKodeAnggaran = $lastKodeAnggaran ? str_pad((int)$lastKodeAnggaran->kode_anggaran + 1, 6, '0', STR_PAD_LEFT) : '000001';
        $nextNoDetailAnggaran = $lastNoDetailAnggaran ? str_pad((int)$lastNoDetailAnggaran->no_detail + 1, 4, '0', STR_PAD_LEFT) : '0001';

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
        $satuans = $querySatuan->orderBy($sortField, $sortDirection)->get();
        $subAnggarans = $queryAnggaran->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);
        return view("pages.anggaran.show_sub_anggaran")->with([
            "anggaran" => $anggaran,
            "subAnggarans" => $subAnggarans,
            "projects" => $projects,
            "sortField" => $sortField,
            "sortDirection" => $sortDirection,
            "perPage" => $perPage,
            "search" => $search,
            "nextKodeAnggaran" => $nextKodeAnggaran,
            "satuans" => $satuans,
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
        // $anggaran = Anggaran::findOrFail($id);
        $validation = $request->validate([
            'nama_anggaran' => 'required',
            'alamat_anggaran' => 'required',
            'telepon_anggaran' => 'required|numeric|max_digits:12',
            'email_anggaran' => 'required|email',
            'status_anggaran' => 'required|string',
            'tgl_bergabung' => 'required|date',
            'tgl_akhir' => 'required|date',
            'project_id' => 'nullable',
        ]);
        $anggaran->update($validation);

        return redirect()->route('suppliers.index')->with([
            'success' => 'Anggaran updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggaran $anggaran)
    {
        // $anggaran = Anggaran::findOrFail($id);
        $anggaran->delete();
        return redirect()->route('suppliers.index')->with('success', 'Anggaran deleted successfully');
    }
}
