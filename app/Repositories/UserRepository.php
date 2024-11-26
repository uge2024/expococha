<?php


namespace App\Repositories;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser($id): ?User
    {
        return $this->user->find($id);
    }

    public function getUserByEmail($email): ?User
    {
        return $this->user->where([
            ['email','=',$email]
        ])->first();
    }

    public function validarCorreoUsuario($email)
    {
        $this->user = $this->user->where([
            ['email','=',$email]
        ])->first();
        if(!empty($this->user)){
            $this->user->email_verified_at = date('Y-m-d H:i:s');
            $this->user->correo_validado = 1;
            $this->user->save();
        }
    }

    public function actualizarDatosUsuario($id,$data):?User
    {
        $user = $this->user->find($id);
        $user->name = $data['name'];
        $user->celular = $data['celular'];
        $user->direccion = $data['direccion'];
        $user->save();
        return $user->fresh();
    }

    public function actualizarContrasenia($id,$contrasenia):?User
    {
        $user = $this->user->find($id);
        $user->password = Hash::make($contrasenia);
        $user->save();
        return $user->fresh();
    }

    public function getTodosUsuariosPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        $campoSearch = $searchtype==1?'name':'email';
        $sortCampo = $sort==1?'name':($sort==2?'email':'rol');
        return $this->user->whereRaw(
          "UPPER($campoSearch) like '%".strtoupper($search)."%'"
        )->orderBy($sortCampo,'asc')->paginate($limit);
    }

    public function saveUsuario($data)
    {
        $user = new $this->user;
        $user->name = $data['name'];
        $user->celular = $data['celular'];
        $user->direccion = $data['direccion'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);;
        $user->estado = $data['estado'];
        $user->rol = $data['rol'];
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->correo_validado = 0;
        if (isset($data['usr_id_creador'])){
            $user->usr_id_creador = $data['usr_id_creador'];
        }
        $user->save();
        return $user->fresh();
    }

    public function updateUsuarioWithoutPassword($data)
    {
        $user = $this->user->find($data['id']);
        $user->name = $data['name'];
        $user->celular = $data['celular'];
        $user->direccion = $data['direccion'];
        $user->email = $data['email'];
        $user->estado = $data['estado'];
        $user->rol = $data['rol'];
        $user->updated_at = date('Y-m-d H:i:s');
        if (isset($data['usr_id_creador'])){
            $user->usr_id_creador = $data['usr_id_creador'];
        }
        $user->save();
        return $user->fresh();
    }

    public function getAllUsersAdministradoresAc()
    {
        return $this->user->where([
            ['estado','=','AC'],
            ['rol','=',3]
        ])->get();
    }

    public function getAllUsersNormalValidado()
    {
        return $this->user->where([
            ['estado','=','AC'],
            ['rol','=',1],
            ['correo_validado','=',1]
        ])->get();
    }
}
