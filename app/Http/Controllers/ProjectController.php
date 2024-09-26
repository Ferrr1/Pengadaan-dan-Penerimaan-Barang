<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $perStatus = $request->input("perStatus", 'all');
        $search = $request->input('search', '');
        $lastKodeProject = Project::orderBy('kode_project', 'desc')->first();
        $nextKodeProject = $lastKodeProject ? str_pad((int)$lastKodeProject->kode_project + 1, 6, '0', STR_PAD_LEFT) : '000001';

        // $searchableColumns = ['kode_project', 'nama_project'];
        if ($search) {
            $query->where("nama_project", "like", "%" . $search . "%")
                ->orWhere("kode_project", "like", "%" . $search . "%");
        }

        if ($perStatus !== 'all') {
            $query->where('status_project', $perStatus);
        }

        if ($perPage === 'all') {

            $projects = $query->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $projects = $query->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }

        return view('pages.project.index', compact('projects', 'sortField', 'sortDirection', 'perPage', 'perStatus', 'nextKodeProject'));
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
    public function store(StoreProjectRequest $request)
    {
        try {
            $validation = $request->validate([
                'nama_project' => 'required',
                'tgl_mulai' => 'required|date',
                'status_project' => 'required|string',
            ]);
            $lastKodeProject = Project::orderBy('kode_project', 'desc')->first();
            $nextKodeProject = $lastKodeProject ? str_pad((int)$lastKodeProject->kode_project + 1, 6, '0', STR_PAD_LEFT) : '000001';

            // Add the next kode_project to the validated data
            $validation['kode_project'] = $nextKodeProject;
            // dd($validation);
            Project::create($validation);

            return redirect()->route('projects.index')->with([
                notyf()->position('y', 'top')->success('Project berhasil dibuat'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Project gagal dibuat. Silakan coba lagi.')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            $validation = $request->validate([
                'nama_project' => 'required',
                'tgl_mulai' => 'required|date',
                'status_project' => 'required',
            ]);
            $project->update($validation);

            return redirect()->route('projects.index')->with([
                notyf()->position('y', 'top')->success('Project berhasil diupdate'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Project gagal diupdate. Silakan coba lagi.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return redirect()->route('projects.index')->with([
                notyf()->position('y', 'top')->success('Project berhasil di hapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Project gagal di hapus. Silakan coba lagi.')]);
        }
    }
}
