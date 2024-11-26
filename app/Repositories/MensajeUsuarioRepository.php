<?php


namespace App\Repositories;


use App\Models\MensajeUsuario;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MensajeUsuarioRepository
{
    protected  $mensajeUsuario;
    public function __construct(MensajeUsuario $mensajeUsuario)
    {
        $this->mensajeUsuario = $mensajeUsuario;
    }

    public function save($data)
    {
        $mensajeUsuario = new $this->mensajeUsuario;
        $mensajeUsuario->mensaje = $data['mensaje'];
        $mensajeUsuario->fecha = $data['fecha'];
        $mensajeUsuario->estado = $data['estado'];
        $mensajeUsuario->visto = $data['visto'];
        $mensajeUsuario->usr_id_r = $data['usr_id_r'];
        $mensajeUsuario->usr_id_e = $data['usr_id_e'];
        $mensajeUsuario->save();
        return $mensajeUsuario->fresh();
    }

    public function getAllUsuariosQueMeMensajearon($usr_id_r)
    {
        $sql1 = "select
                m2.recive,
                m2.envia,
                m2.fecha,
                m2.meu_id
                from
                (
                    select
                    m1.recive as recive,
                    m1.envia as envia,
                    max(m1.fecha) as fecha,
                    max(m1.meu_id) as meu_id
                    from
                    (
                        select  meu.usr_id_r as recive,meu.usr_id_e envia,max(meu.fecha) as fecha,max(meu.meu_id) as meu_id from
                        meu_mensaje_usuario as meu
                        where meu.usr_id_r = $usr_id_r
                        group by meu.usr_id_r,meu.usr_id_e
                        union
                        select  meu.usr_id_e as recive,meu.usr_id_r as envia,max(meu.fecha) as fecha,max(meu.meu_id) as meu_id  from
                        meu_mensaje_usuario as meu
                        where meu.usr_id_e = $usr_id_r
                        group by meu.usr_id_e,meu.usr_id_r
                    ) as m1
                    group by m1.recive,m1.envia
                ) as m2
                order by m2.fecha desc ";
        $resultado = DB::select(DB::raw($sql1));

        $usuarios = new Collection();
        foreach ($resultado as $val)
        {
            $usuario = User::where([
                ['id','=',$val->envia],
                ['estado','=','AC']
            ])->first();
            if (!empty($usuario)){
                $mensajeUltimo = MensajeUsuario::find($val->meu_id);
                if (!empty($mensajeUltimo)){
                    $usuario->meu_id = $val->meu_id;
                    if ($mensajeUltimo->usr_id_r == $usr_id_r){
                        $usuario->esrecivido = 1;
                        $usuario->esvisto = $mensajeUltimo->visto;
                    }else{
                        $usuario->esrecivido = 0;
                        $usuario->esvisto = $mensajeUltimo->visto;
                    }
                    $usuario->fechaenvio = $val->fecha;
                    $usuarios->push($usuario);
                }

            }
        }

        return $usuarios;
    }

    public function getAllMensajesConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e)
    {
        return $this->mensajeUsuario->where([
            ['usr_id_r','=',$usr_id_r],
            ['usr_id_e','=',$usr_id_e]
        ])->orWhere([
            ['usr_id_r','=',$usr_id_e],
            ['usr_id_e','=',$usr_id_r]
        ])->orderBy('fecha','asc')->limit(1000)->get();
    }

    public function getAllMensajesConversacionByReceptorAndEmisorAndUltimoMensaje($usr_id_r,$usr_id_e,$meu_id)
    {
        return $this->mensajeUsuario->where([
            ['usr_id_r','=',$usr_id_r],
            ['usr_id_e','=',$usr_id_e],
            ['meu_id','>',$meu_id]
        ])->orWhere([
            ['usr_id_r','=',$usr_id_e],
            ['usr_id_e','=',$usr_id_r],
            ['meu_id','>',$meu_id]
        ])->orderBy('fecha','asc')->get();
    }

    public function actualizarAllVistoConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e)
    {
        $this->mensajeUsuario->where([
            ['usr_id_r','=',$usr_id_r],
            ['usr_id_e','=',$usr_id_e]
        ])->update(['visto'=>1]);
    }

    public function getEstadoVistoUltimoMensajeEnvie($usr_id_r,$usr_id_e)
    {
        $res = 0;
        $ultimo = $this->mensajeUsuario->where([
            ['usr_id_r','=',$usr_id_r],
            ['usr_id_e','=',$usr_id_e],
        ])->orderBy('meu_id','desc')->first();
        if (!empty($ultimo)){
            $res = $ultimo->visto;
        }
        return $res;
    }

    public function countMensajesQueMeEnviaronSinLeer($usr_id_r)
    {
        $res = 0;
        $sql1 = "select
                m2.recive,
                m2.envia,
                m2.fecha,
                m2.meu_id
                from
                (
                    select
                    m1.recive as recive,
                    m1.envia as envia,
                    max(m1.fecha) as fecha,
                    max(m1.meu_id) as meu_id
                    from
                    (
                        select  meu.usr_id_r as recive,meu.usr_id_e envia,max(meu.fecha) as fecha,max(meu.meu_id) as meu_id from
                        meu_mensaje_usuario as meu
                        where meu.usr_id_r = $usr_id_r
                        group by meu.usr_id_r,meu.usr_id_e
                        union
                        select  meu.usr_id_e as recive,meu.usr_id_r as envia,max(meu.fecha) as fecha,max(meu.meu_id) as meu_id  from
                        meu_mensaje_usuario as meu
                        where meu.usr_id_e = $usr_id_r
                        group by meu.usr_id_e,meu.usr_id_r
                    ) as m1
                    group by m1.recive,m1.envia
                ) as m2
                order by m2.fecha desc ";
        $resultado = DB::select(DB::raw($sql1));

        $usuarios = new Collection();
        foreach ($resultado as $val)
        {
            $usuario = User::where([
                ['id','=',$val->envia],
                ['estado','=','AC']
            ])->first();
            if (!empty($usuario)){
                $mensajeUltimo = MensajeUsuario::find($val->meu_id);
                if (!empty($mensajeUltimo)){
                    $usuario->meu_id = $val->meu_id;
                    if ($mensajeUltimo->usr_id_r == $usr_id_r){
                        $usuario->esrecivido = 1;
                        $usuario->esvisto = $mensajeUltimo->visto;
                        $usuario->fechaenvio = $val->fecha;
                        $usuarios->push($usuario);
                    }else{
                        $usuario->esrecivido = 0;
                        $usuario->esvisto = $mensajeUltimo->visto;
                        $usuario->fechaenvio = $val->fecha;
                        //$usuarios->push($usuario);
                    }
                }
            }
        }

        foreach ($usuarios as $usuario){
            if ($usuario->esvisto == 0){
                $res++;
            }
        }

        return $res;
    }

}
