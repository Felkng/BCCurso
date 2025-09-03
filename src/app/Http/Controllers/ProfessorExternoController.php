<?php

namespace App\Http\Controllers;

use App\Models\ProfessorExterno;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class professorExternoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        if ($buscar) {
            $professores_externos = ProfessorExterno::where('nome', 'like', '%' . $buscar . '%')->get();
        } else {
            $professores_externos = ProfessorExterno::all();
        }

        if ($request->contexto) {
            $professores_externos = ProfessorExterno::all();
            return response()->json(['professoresExternos' => $professores_externos]);
        }

        return view('professor-externo.index', ['professores_externos' => $professores_externos, 'buscar' => $buscar]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos campos obrigatórios
        $request->validate([
            'nome' => 'required|string|max:255',
            'filiacao' => 'required|string|max:255'
        ]);

        // Verifica se já existe um professor externo com o mesmo nome e filiação (ignorando case e espaços)
        $professorExistente = ProfessorExterno::whereRaw('LOWER(TRIM(nome)) = ?', [strtolower(trim($request->nome))])
            ->whereRaw('LOWER(TRIM(filiacao)) = ?', [strtolower(trim($request->filiacao))])
            ->first();

        if ($professorExistente) {
            // Se já existe, retorna o existente
            $novoProfessor = $professorExistente;
            $mensagem = 'Professor externo já existe e foi selecionado.';
            $jaExistia = true;
        } else {
            // Se não existe, cria um novo (normalizando os dados)
            $novoProfessor = ProfessorExterno::create([
                'nome' => trim($request->nome),
                'filiacao' => trim($request->filiacao)
            ]);
            $mensagem = 'Professor externo criado com sucesso.';
            $jaExistia = false;
        }

        if ($request->contexto == 'modal') {
            // Garantir que todos os campos estão presentes na resposta
            $professorData = [
                'id' => $novoProfessor->id,
                'nome' => $novoProfessor->nome,
                'filiacao' => $novoProfessor->filiacao,
                'created_at' => $novoProfessor->created_at,
                'updated_at' => $novoProfessor->updated_at
            ];

            return response()->json([
                'professor_externo' => $professorData,
                'mensagem' => $mensagem,
                'ja_existia' => $jaExistia
            ]);
        } else {
            return redirect('professor-externo')->with('success', 'Professor externo ' . $request->nome . ' Criado com Sucesso');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $professorExterno = ProfessorExterno::findOrFail($id);
            
            // Verifica se o professor está sendo usado em alguma banca
            $bancasCount = $professorExterno->bancas()->count();
            
            if ($bancasCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir este professor pois ele está sendo usado em ' . $bancasCount . ' banca(s).'
                ], 422);
            }
            
            $professorExterno->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Professor externo excluído com sucesso!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir professor externo: ' . $e->getMessage()
            ], 500);
        }
    }
}
