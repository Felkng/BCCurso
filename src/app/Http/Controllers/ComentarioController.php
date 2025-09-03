<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Postagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000',
            'postagem_id' => 'required|exists:postagem,id'
        ]);

        $comentario = Comentario::create([
            'conteudo' => $request->conteudo,
            'postagem_id' => $request->postagem_id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000'
        ]);

        $comentario = Comentario::findOrFail($id);

        // Verificar se o usuário pode editar este comentário
        if ($comentario->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para editar este comentário.');
        }

        $comentario->update([
            'conteudo' => $request->conteudo,
            'editado_em' => now()
        ]);

        return redirect()->back()->with('success', 'Comentário editado com sucesso!');
    }

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);

        // Verificar se o usuário pode deletar este comentário
        $user = Auth::user();
        if ($comentario->user_id !== $user->id && !$user->hasRole('coordenador')) {
            return redirect()->back()->with('error', 'Você não tem permissão para deletar este comentário.');
        }

        $comentario->delete();

        return redirect()->back()->with('success', 'Comentário deletado com sucesso!');
    }
}
