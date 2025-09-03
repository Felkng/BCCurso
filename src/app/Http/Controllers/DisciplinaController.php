<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisciplinaRequest;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        if ($buscar) {
            $disciplinas = Disciplina::where('nome', 'like', '%' . $buscar . '%')
                ->orWhere('periodo', $buscar)
                ->orderBy('periodo')
                ->orderBy('nome')
                ->get();
        } else {
            $disciplinas = Disciplina::orderBy('periodo')
                ->orderBy('nome')
                ->get();
        }

        return view('disciplina.index', compact('disciplinas', 'buscar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('disciplina.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DisciplinaRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['optativa']) && $validated['optativa']) {
            $validated['periodo'] = 0;
        }

        Disciplina::create($validated);

        return redirect()->route('disciplina.index')
            ->with('success', 'Disciplina cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disciplina $disciplina)
    {
        return view('disciplina.show', compact('disciplina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disciplina $disciplina)
    {
        return view('disciplina.edit', compact('disciplina'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DisciplinaRequest $request, Disciplina $disciplina)
    {
        $validated = $request->validated();

        if (isset($validated['optativa']) && $validated['optativa']) {
            $validated['periodo'] = 0;
        }

        $disciplina->update($validated);

        return redirect()->route('disciplina.index')
            ->with('success', 'Disciplina atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();

        return redirect()->route('disciplina.index')
            ->with('success', 'Disciplina excluída com sucesso');
    }
}

