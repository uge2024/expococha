<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Toastr;

class BackupController extends Controller
{
    protected $backupService;
    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = 10;
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $fecha_inicio = date('d/m/Y');
        $fecha_fin = date('d/m/Y');
        if ($request->has('search')){
            $searchtype = $request->searchtype;
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        if ($request->has('fecha_inicio')){
            $fecha_inicio = $request->fecha_inicio;
        }
        if ($request->has('fecha_fin')){
            $fecha_fin = $request->fecha_fin;
        }

        $lista = $this->backupService->getTodosPaginateBySearchAndSort($limit,$searchtype,$search,$sort,$fecha_inicio,$fecha_fin);
        return view('backup.index',compact('lista','searchtype','search','sort','fecha_inicio','fecha_fin'));
    }

    public function create(Request $request){
        $user = Auth::user();
        $ip = $request->ip();
        $backup = new Backup();
        $backup->bac_id = 0;
        $backup->ip = $ip;
        $backup->usuario = $user->name;
        return view('backup.create',compact('backup'));
    }

    public function store(Request $request){
        $data = $request->except('_token');
        $messages = [
            'required' => 'El campo :attribute es requerido.',
        ];

        $validator = Validator::make($data, [
            'ip' => 'required',
            'usuario' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data['fecha']= date('Y-m-d H:i:s');
        $nombre = 'backup_expococha_'.now()->format('YmdHis').'.backup';
        $res = $this->backup($nombre);
        if($res==false){
            Toastr::error('No se pudo guardar el backup de la base de datos', "");
            return back()->withInput();
        }
        $data['archivo'] = $nombre;
        try {

            $backup = $this->backupService->save($data);
            if (empty($backup)) {
                Toastr::error('No se pudo guardar el backup de la base de datos', "");
            }else{
                Toastr::success('Operación completada ', "");
                return redirect('backups');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Ocurrio un error al guardar el backup de la base de datos', "");
            return back()->withInput();
        }

    }

    private function backup($nombre){
        $res = true;
        try {
            /*$ruta = storage_path(sprintf('app/public/uploads/') );
            $completo = $ruta.''.$nombre;
            $pass = config('database.connections.pgsql.password');
            $usuario = config('database.connections.pgsql.username');
            $db = config('database.connections.pgsql.database');
            $process = Process::fromShellCommandline(sprintf(
                'pg_dump --username=%s %s > %s',
                $usuario,
                $db,
                $completo
            ));
            $process->mustRun();*/
            $ruta = storage_path(sprintf('app/public/uploads/') );
            $completo = $ruta.''.$nombre;
            $pass = config('database.connections.pgsql.password');
            $usuario = config('database.connections.pgsql.username');
            $db = config('database.connections.pgsql.database');
            $process = Process::fromShellCommandline(sprintf(
                'pg_dump -U %s -F c -E utf8 %s > %s',
                $usuario,
                $db,
                $completo
            ));
            $process->mustRun();
        }catch (ProcessFailedException $exception) {
            Log::error('Error en el backup '.$exception->getMessage().' '.$exception->getTraceAsString());
            $res = false;
        }
        return $res;
    }

}
