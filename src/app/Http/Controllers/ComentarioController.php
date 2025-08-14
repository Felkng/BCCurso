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

        return redirect()->route('postagem.show', ['id' => $request->postagem_id])->with('success', 'Comentário adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000'
        ]);

        $comentario = Comentario::findOrFail($id);

        // Verificar se o usuário pode editar este comentário
        if ($comentario->user_id !== Auth::id()) {
            return redirect()->route('postagem.show', ['id' => $comentario->postagem_id])->with('error', 'Você não tem permissão para editar este comentário.');
        }

        $comentario->update([
            'conteudo' => $request->conteudo,
            'editado_em' => now()
        ]);

        return redirect()->route('postagem.show', ['id' => $comentario->postagem_id])->with('success', 'Comentário editado com sucesso!');
    }

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);

        // Verificar se o usuário pode deletar este comentário
        $user = Auth::user();
        if ($comentario->user_id !== $user->id && !$user->hasRole('coordenador')) {
            return redirect()->route('postagem.show', ['id' => $comentario->postagem_id])->with('error', 'Você não tem permissão para deletar este comentário.');
        }

        $postagem_id = $comentario->postagem_id; // Armazenar antes de deletar
        $comentario->delete();

        return redirect()->route('postagem.show', ['id' => $postagem_id])->with('success', 'Comentário deletado com sucesso!');
    }
}
