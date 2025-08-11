<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostagemRequest;
use App\Models\Aluno;
use App\Models\ArquivoPostagem;
use App\Models\Banca;
use App\Models\ImagemPostagem;
use App\Models\CapaPostagem;
use App\Models\Postagem;
use App\Models\Professor;
use App\Models\TipoPostagem;
use App\Models\PinnedPosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use HTMLPurifier;
use HTMLPurifier_Config;

class PostagemController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $postagens = Postagem::when($buscar, function ($query, $buscar) {
            return $query->where('titulo', 'like', '%' . $buscar . '%');
        })->get();

        return view('postagem.index', ['postagens' => $postagens, 'buscar' => $buscar]);
    }

    public function create()
    {
        $tipo_postagens = TipoPostagem::pluck('nome', 'id');
        $id = 1;
        $postagem = null;

        if (old() && URL::previous() === route('tcc.create')) {
            try {
                $banca = Banca::findOrFail(old('banca_id'));
                $professor = Professor::findOrFail(old('professor_id'));
                $aluno = Aluno::findOrFail(old('aluno_id'));

                $postagem = [
                    'titulo' => 'Convite TCC',
                    'texto' =>
                        'Aluno: ' . $aluno->nome . "\n" .
                        'Título: ' . old('titulo') . "\n" .
                        'Orientador: ' . $professor->servidor->nome . "\n" .
                        'Data: ' . date('d/m/Y', strtotime($banca->data)) . "\n" .
                        'Local: ' . $banca->local
                ];
            } catch (\Exception $e) {
                $postagem = null;
            }
        }

        return view('postagem.create', compact('tipo_postagens', 'id', 'postagem'));
    }

    public function store(PostagemRequest $request)
    {
        try {
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $cleanText = $purifier->purify($request->texto);

            $postagem = new Postagem([
                'titulo' => $request->titulo,
                'texto' => $cleanText,
                'tipo_postagem_id' => $request->tipo_postagem_id,
                'menu_inicial' => false,
            ]);

            $postagem->save();

            if ($request->filled('cropped_image_data')) {
                $imageData = $request->input('cropped_image_data');

                if (strpos($imageData, 'data:image') !== false) {
                    [, $imageData] = explode(',', $imageData);
                }

                $decodedImage = base64_decode($imageData);

                if (!$decodedImage) {
                    throw new \Exception('Falha ao decodificar imagem base64');
                }

                $directory = 'CapaPostagem/' . $postagem->id;
                Storage::disk('public')->makeDirectory($directory);

                $fileName = uniqid('capa_') . '.jpg';
                $fullPath = $directory . '/' . $fileName;

                if (!Storage::disk('public')->put($fullPath, $decodedImage)) {
                    throw new \Exception('Falha ao salvar arquivo de imagem');
                }

                $capaPostagem = new CapaPostagem();
                $capaPostagem->postagem_id = $postagem->id;
                $capaPostagem->imagem = $fullPath;
                $capaPostagem->save();

                $postagem->menu_inicial = true;
                $postagem->save();
            }

            if ($request->hasFile('imagens')) {
                foreach ($request->file('imagens') as $imagem) {
                    if ($imagem->isValid() && str_starts_with($imagem->getMimeType(), 'image/')) {
                        $imagemPostagem = new ImagemPostagem();
                        $imagemPostagem->postagem_id = $postagem->id;
                        $imagemPostagem->imagem = $imagem->store('ImagemPostagem/' . $postagem->id, 'public');
                        $imagemPostagem->save();
                    }
                }
            }

            if ($request->hasFile('arquivos')) {
                foreach ($request->file('arquivos') as $arquivo) {
                    if ($arquivo->isValid()) {
                        $arquivoPostagem = new ArquivoPostagem();
                        $arquivoPostagem->postagem_id = $postagem->id;
                        $arquivoPostagem->nome = $arquivo->getClientOriginalName();
                        $arquivoPostagem->path = $arquivo->store('ArquivoPostagem/' . $postagem->id, 'public');
                        $arquivoPostagem->save();
                    } else {
                        Log::warning('Arquivo inválido detectado no upload de postagem: ' . $arquivo->getClientOriginalName());
                    }
                }
            }

            return redirect('postagem')->with('success', 'Postagem Criada com Sucesso');
        } catch (\Exception $e) {
            Log::error('Erro ao criar postagem: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Erro ao criar a postagem: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $postagem = Postagem::findOrFail($id);
        $tipo_postagens = TipoPostagem::pluck('nome', 'id');

        return view('postagem.edit', ['postagem' => $postagem, 'tipo_postagens' => $tipo_postagens]);
    }

    public function update(PostagemRequest $request, string $id)
    {
        try {
            $postagem = Postagem::findOrFail($id);

            if ($request->filled('cropped_image_data')) {
                $imageData = $request->input('cropped_image_data');

                if (strpos($imageData, 'data:image') !== false) {
                    [, $imageData] = explode(',', $imageData);
                }

                $decodedImage = base64_decode($imageData);

                if ($decodedImage === false) {
                    throw new \Exception('Falha ao decodificar imagem base64');
                }

                $oldCapaPostagem = $postagem->capa;
                if ($oldCapaPostagem) {
                    Storage::disk('public')->delete($oldCapaPostagem->imagem);
                    $oldCapaPostagem->delete();
                }

                $directory = 'CapaPostagem/' . $postagem->id;
                Storage::disk('public')->makeDirectory($directory);

                $fileName = uniqid('capa_') . '.jpg';
                $fullPath = $directory . '/' . $fileName;

                if (!Storage::disk('public')->put($fullPath, $decodedImage)) {
                    throw new \Exception('Falha ao salvar arquivo de imagem');
                }

                $capaPostagem = new CapaPostagem();
                $capaPostagem->postagem_id = $postagem->id;
                $capaPostagem->imagem = $fullPath;
                $capaPostagem->save();

                $postagem->menu_inicial = true;
            }

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $cleanText = $purifier->purify($request->texto);

            $postagem->update([
                'titulo' => $request->titulo,
                'texto' => $cleanText,
                'tipo_postagem_id' => $request->tipo_postagem_id,
                'menu_inicial' => $postagem->menu_inicial ?? false
            ]);

            if ($request->hasFile('imagens')) {
                foreach ($request->file('imagens') as $imagem) {
                    if ($imagem->isValid() && str_starts_with($imagem->getMimeType(), 'image/')) {
                        $imagemPostagem = new ImagemPostagem();
                        $imagemPostagem->postagem_id = $postagem->id;
                        $imagemPostagem->imagem = $imagem->store('ImagemPostagem/' . $postagem->id, 'public');
                        $imagemPostagem->save();
                    }
                }
            }

            if ($request->hasFile('arquivos')) {
                foreach ($request->file('arquivos') as $arquivo) {
                    if ($arquivo->isValid()) {
                        $arquivoPostagem = new ArquivoPostagem();
                        $arquivoPostagem->postagem_id = $postagem->id;
                        $arquivoPostagem->nome = $arquivo->getClientOriginalName();
                        $arquivoPostagem->path = $arquivo->store('ArquivoPostagem/' . $postagem->id, 'public');
                        $arquivoPostagem->save();
                    }
                }
            }

            return redirect('postagem')->with('success', 'Postagem Alterada com Sucesso');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar postagem: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar a postagem: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $postagem = Postagem::findOrFail($id);

        foreach ($postagem->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->imagem);
        }
        foreach ($postagem->arquivos as $arquivo) {
            Storage::disk('public')->delete($arquivo->path);
        }
        if ($postagem->capa) {
            Storage::disk('public')->delete($postagem->capa->imagem);
        }

        $postagem->delete();
        return back()->with('success', 'Postagem Excluída com Sucesso');
    }

    public function deleteImagem($id)
    {
        $imagem = ImagemPostagem::findOrFail($id);

        if (Storage::disk('public')->exists($imagem->imagem)) {
            Storage::disk('public')->delete($imagem->imagem);
        }
        $imagem->delete();
        return back()->with('success', 'Imagem excluída com sucesso.');
    }

    public function deleteArquivo($id)
    {
        $arquivo = ArquivoPostagem::findOrFail($id);

        if (Storage::disk('public')->exists($arquivo->path)) {
            Storage::disk('public')->delete($arquivo->path);
        }
        $arquivo->delete();
        return back()->with('success', 'Arquivo excluído com sucesso.');
    }

    public function display()
    {
        $postagens = Postagem::orderBy('created_at', 'desc')->get();
        $postagens_9 = Postagem::orderBy('created_at', 'desc')->paginate(9);

        return view('postagem.display', ['postagens' => $postagens, 'postagens_9' => $postagens_9]);
    }

    public function show(string $id)
    {
        $postagem = Postagem::findOrFail($id);
        $tipo_postagem = TipoPostagem::findOrFail($postagem->tipo_postagem_id);
        return view('postagem.show', ['postagem' => $postagem, 'tipo_postagem' => $tipo_postagem]);
    }

    public function togglePin(Postagem $postagem)
    {
        $capa = $postagem->capa;

        if (!$capa) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => "Nenhuma imagem encontrada para essa postagem.",
            ]);
        }

        $imagem = $capa->imagem;
        $imagePath = public_path('storage/' . $imagem);

        if (!Postagem::checkMainImageSize($imagePath)) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => "A imagem principal não possui as dimensões necessárias.",
            ]);
        }

        $pinnedpost = PinnedPosts::find($postagem->id);
        if ($pinnedpost) {
            $pinnedpost->delete();
            $status = 'unpinned';
            $message = "Postagem '{$postagem->titulo}' desfixada com sucesso.";
        } else {
            PinnedPosts::create(['postagem_id' => $postagem->id]);
            $status = 'pinned';
            $message = "Postagem '{$postagem->titulo}' fixada com sucesso.";
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $message,
        ]);
    }
}
