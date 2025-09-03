<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\AlunoRequest;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::all();
        return view('alunos.index', compact('alunos'));
    }

    public function create()
    {
        return view('alunos.create');
    }

    public function store(AlunoRequest $request)
{
    DB::beginTransaction();
    try {
        $user = User::create([
            'password' => Hash::make(strtolower($request->email)),
            'name' => $request->nome,
            'email' => strtolower($request->email),
        ]);

        $user->assignRole('aluno');

        $aluno = Aluno::create([
            'nome' => $request->nome,
            'matricula' => $request->matricula,
            'user_id' => $user->id,
        ]);

        DB::commit();

    } catch (\Exception $dbError) {
        DB::rollBack(); 
        if ($request->input('contexto') === 'modal') {
            return response()->json(['success' => false, 'message' => 'Erro no banco de dados: ' . $dbError->getMessage()], 500);
        }
        // Use JavaScript alert instead of session flash message to avoid duplicates
        return redirect('/aluno')->with('js_alert', [
            'type' => 'error',
            'message' => 'Erro ao cadastrar aluno no banco de dados!'
        ]);
    }

    try {
        $email = new CredentialMail($request);
        $email->sendMail();
    } catch (\Exception $emailError) {
        if ($request->input('contexto') === 'modal') {
            return response()->json([
                'success' => true, 
                'aluno' => $aluno,
                'warning' => 'Aluno cadastrado, mas o e-mail de credenciais falhou. Erro: ' . $emailError->getMessage()
            ]);
        }
        // Use JavaScript alert instead of session flash message to avoid duplicates
        return redirect('/aluno')->with('js_alert', [
            'type' => 'warning',
            'message' => 'Aluno cadastrado com sucesso, mas o envio de e-mail falhou! Envie as credenciais manualmente.'
        ]);
    }

    if ($request->input('contexto') === 'modal') {
        return response()->json([
            'success' => true,
            'aluno' => $aluno
        ]);
    }

    // Use JavaScript alert instead of session flash message to avoid duplicates
    return redirect('/aluno')->with('js_alert', [
        'type' => 'success',
        'message' => 'Aluno cadastrado com sucesso e e-mail enviado!'
    ]);
}
    public function edit($id)
    {
        $aluno = Aluno::findOrFail($id);
        return view('alunos.edit', compact('aluno'));
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update([
            'nome' => $request->nome,
            'matricula' => $request->matricula,
        ]);

        return redirect()->route('aluno.index');
    }

    public function destroy($id)
    {
        try {
            $aluno = Aluno::where('id', $id)->first();
            Aluno::destroy($id);
            User::destroy($aluno->user_id);
            $tipo = "success";
            $mensagem = "Aluno removido com sucesso!";
        } catch (QueryException) {
            $tipo = "error";
            $mensagem = "Aluno utilizado no sistema!";
        }

        return redirect('/aluno')->with($tipo, $mensagem);
    }
}
