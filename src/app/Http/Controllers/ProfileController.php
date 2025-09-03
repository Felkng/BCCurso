<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\FotoUser;
use App\Models\Servidor;
use App\Models\Professor;
use App\Models\AreaProfessor;
use App\Models\CurriculoProfessor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\UploadedFile;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $servidor = $user->servidor;
        $professor = $servidor ? $servidor->professor : null;
        
        // Específico para aluno
        if ($user->hasRole('aluno')) {
            $aluno = $user->aluno;
            
            return view('profile.edit-aluno', [
                'user' => $user,
                'aluno' => $aluno ?? null, // Garantir que não será undefined
            ]);
        }
        
        // Para professores e outros usuários
        return view('profile.edit', [
            'user' => $user,
            'professor' => $professor,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Se for aluno, usar lógica simplificada
        if ($user->hasRole('aluno')) {
            return $this->updateAlunoProfile($request);
        }
        
        // Lógica original para professores
        return $this->updateProfessorProfile($request);
    }

    /**
     * Update aluno profile information
     */
    private function updateAlunoProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update professor profile information  
     */
    private function updateProfessorProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $request->user()->fill($request->validated());
        $user = $request->user(); // Obtenha a instância do usuário
        $servidor = Servidor::where('user_id', $user->id)->first();
        $professor = Professor::where('servidor_id', $servidor->id)->first();
        
        
        $user->update([
            'curriculo_lattes' => $request->curriculo_lattes,
        ]);


        //Nova forma de realizar update nos dados
            //Professor com foto 
        if ($request->hasFile("fotos")) {
            $fotos = $request->file("fotos");
            
            $professor->update([
                'titulacao'=> $request->titulacao,
                'biografia'=> $request->biografia,
                'area'=> $request->area,
                'foto' => $fotos[0]->store('FotoUser/' . $user->id),
            ]);
            //$professor->save();
        }else { //Professor sem foto
            $professor->update([
                'titulacao'=> $request->titulacao,
                'biografia'=> $request->biografia,
                'area'=> $request->area,
            ]);
        }

        // Removido: AreaProfessor::updateOrCreate - agora o campo area está na tabela professor
        
        //nova forma de salvar os links na nova tabela LINK
        $curriculo = CurriculoProfessor::firstOrCreate(
        ['professor_id' => $professor->id]);

        if ($request->has('links')) {
            foreach ($request->input('links') as $linkId => $linkUrl) {
                $link = \App\Models\Link::find($linkId);
                if ($link && $link->curriculo_professor_id == $curriculo->id) {
                //Se o usuário limpou o campo, apaga o link
                    if (empty($linkUrl)) {
                    $link->delete();
                    }else{
                        $link->update(['link' => $linkUrl]);
                    }
                }
            }
        }
        //criando links
        if($request->has('new_links')) {
            foreach($request->input('new_links') as $linkUrl) {
                if(!empty($linkUrl)) {
                    $curriculo->links()->firstOrCreate(['link' => $linkUrl]);
                }
            }
        } 

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();


        //forma antiga de fazer update nas fotos (mantive)
        if ($request->hasFile("fotos")) {
           $fotos = $request->file("fotos");              

           foreach ($fotos as $foto) {
                $fotoUser = new FotoUser();
                $fotoUser->user_id = $user->id;
                $fotoUser->foto = $foto->store('FotoUser/' . $user->id);
                $fotoUser->save();
                unset($fotoUser);
            }
        }


        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->hasRole('coordenador')) {
        $coordinatorCount = \App\Models\User::role('coordenador')->count();
            if ($coordinatorCount <= 1) {
                return back()->withErrors(['password' => 'Você não pode excluir seu perfil porque é o único coordenador do
                sistema. Por favor, nomeie outro coordenador antes de remover sua conta.'],
                'userDeletion'
                );
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('noticias');
    }

    /**
     * Display a listing of the resource.
     */
    public function display(Request $request)
    {
        $buscar = $request->buscar;
        if ($buscar) {
            $users = User::where('name', 'like', '%' . $buscar . '%')->get();
        } else {
            $users = User::all();
        }

        return view('profile.display', ['users' => $users, 'buscar' => $buscar]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        if ($buscar) {
            $users = User::where('name', 'like', '%' . $buscar . '%')->get();
        } else {
            $users = User::all();
        }

        return view('profile.index', ['users' => $users, 'buscar' => $buscar]);
    }

    /** 
    *Delete the specified image.
    */
    public function deleteFoto($id)
    {
        $foto = FotoUser::findOrFail($id);

        if (File::exists("storage/"  . $foto->foto)) {
            File::delete("storage/"  . $foto->foto);
        }
        $foto->delete();
        return back();
    }

}
