<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Postagem;
use App\Models\Tcc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'type' => 'required|in:postagem,tcc',
            'id' => 'required|integer'
        ]);

        $type = $request->type;
        $id = $request->id;
        $userId = Auth::id();

        // Determinar o modelo baseado no tipo
        if ($type === 'postagem') {
            $modelo = Postagem::findOrFail($id);
            $modeloClass = Postagem::class;
        } else {
            $modelo = Tcc::findOrFail($id);
            $modeloClass = Tcc::class;
        }

        // Verificar se já existe o favorito
        $favorito = Favorito::where('user_id', $userId)
            ->where('favoritavel_type', $modeloClass)
            ->where('favoritavel_id', $id)
            ->first();

        if ($favorito) {
            // Se já existe, remover
            $favorito->delete();
            $message = 'Removido dos favoritos!';
            $favorited = false;
        } else {
            // Se não existe, criar
            Favorito::create([
                'user_id' => $userId,
                'favoritavel_type' => $modeloClass,
                'favoritavel_id' => $id
            ]);
            $message = 'Adicionado aos favoritos!';
            $favorited = true;
        }

        // Se for uma requisição AJAX, retornar JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'favorited' => $favorited,
                'total_favoritos' => $modelo->totalFavoritos()
            ]);
        }

        // Redirecionar de volta para a página específica baseada no tipo
        if ($type === 'postagem') {
            return redirect()->route('postagem.show', ['id' => $id])->with('success', $message);
        } else {
            return redirect()->route('tcc.view', ['id' => $id])->with('success', $message);
        }
    }

    public function meusFavoritos()
    {
        $user = Auth::user();
        
        $postagensFavoritas = $user->postagensFavoritas()->with('favoritavel.capa')->get();
        $tccsFavoritos = $user->tccsFavoritos()->with('favoritavel.aluno')->get();

        return view('favoritos.index', compact('postagensFavoritas', 'tccsFavoritos'));
    }
}
