<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function destroy(Link $link)
    {
        // Medida de segurança importantíssima:
        // Verifica se o usuário logado é o dono do link que está tentando apagar.
        $professorDoLink = $link->curriculoProfessor->professor;
        $userLogado = Auth::user();

        if ($userLogado->id !== $professorDoLink->servidor->user_id) {
            return response()->json(['success' => false, 'message' => 'Não autorizado.'], 403);
        }

        $link->delete();

        return response()->json(['success' => true, 'message' => 'Link excluído com sucesso.']);
    }
}
