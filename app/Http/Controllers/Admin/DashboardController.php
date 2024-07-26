<?php

namespace App\Http\Controllers\Admin;

use App\Models\Register;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uptId = auth()->guard('admin')->user()->upt_id;
        $isPusat = $uptId == env('UPT_PUSAT_ID', 1000);

        $total = Register::when($uptId, function ($query, $uptId) use ($isPusat) {
            if (!$isPusat) {
                $query->where('master_upt_id', $uptId);
            }
        })->count();

        $setuju = Register::when($uptId, function ($query, $uptId) use ($isPusat) {
            if (!$isPusat) {
                $query->where('master_upt_id', $uptId);
            }
        })
            ->where('status', 'DISETUJUI')
            ->count();

        $tolak = Register::when($uptId, function ($query, $uptId) use ($isPusat) {
            if (!$isPusat) {
                $query->where('master_upt_id', $uptId);
            }
        })
            ->where('status', 'DITOLAK')
            ->count();

        $menunggu = Register::when($uptId, function ($query, $uptId) use ($isPusat) {
            if (!$isPusat) {
                $query->where('master_upt_id', $uptId);
            }
        })
            ->where('status', 'MENUNGGU')
            ->count();



        return view('admin.dashboard.index', compact('total', 'setuju', 'tolak', 'menunggu'));
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
    public function store(Request $request)
    {
        //
    }

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
        //
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
        //
    }
}
