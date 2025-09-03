<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IntencaoMatricula;
use Illuminate\Http\Request;

class IntencaoMatriculaController extends Controller
{
    /**
     * Retorna as disciplinas de uma intenção de matrícula
     */
    public function getDisciplinas($id)
    {
        try {
            $intencaoMatricula = IntencaoMatricula::with('disciplinas')->findOrFail($id);
            return response()->json($intencaoMatricula->disciplinas);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Erro ao buscar disciplinas: ' . $e->getMessage()
            ], 500);
        }
    }
}
