<?php


namespace App\Services;

use App\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser($id):?User
    {
        return $this->userRepository->getUser($id);
    }

    public function getUserByEmail($email):?User
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function validarCorreoUsuario($email):bool
    {
        $res = true;
        try {
            $this->userRepository->validarCorreoUsuario($email);
        }catch (Exception $e){
            $res = false;
            Log::error($e->getMessage(),$e->getTrace());
        }
        return  $res;
    }

    public function actualizarDatosUsuario($id,$data):?User
    {
        try {
            return $this->userRepository->actualizarDatosUsuario($id,$data);
        }catch (Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function actualizarContrasenia($id,$contrasenia):?User
    {
        try {
            return $this->userRepository->actualizarContrasenia($id,$contrasenia);
        }catch (Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function getTodosUsuariosPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        return $this->userRepository->getTodosUsuariosPaginateBySearchAndSort($limit,$searchtype,$search,$sort);
    }

    public function saveUsuario($data)
    {
        try {
            return $this->userRepository->saveUsuario($data);
        }catch (Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function updateUsuarioWithoutPassword($data)
    {
        try {
            return $this->userRepository->updateUsuarioWithoutPassword($data);
        }catch (Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function getAllUsersAdministradoresAc()
    {
        return $this->userRepository->getAllUsersAdministradoresAc();
    }

    public function getAllUsersNormalValidado()
    {
        return $this->userRepository->getAllUsersNormalValidado();
    }


}
