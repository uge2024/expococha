<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbpgsql:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saca una copia de la base de datos';

    /**
     * @var Process
     */
    protected $process;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        //windows
        //$ruta = storage_path(sprintf('app\public\uploads\\'));
        //linux
        $ruta = storage_path(sprintf('app/public/uploads/'));
        $nombre = 'backup_'.now()->format('YmdHis').'.sql';
        $completo = $ruta.''.$nombre;
        $pass = config('database.connections.pgsql.password');
        $usuario = config('database.connections.pgsql.username');
        $db = config('database.connections.pgsql.database');

        $this->process = Process::fromShellCommandline(sprintf(
            'pg_dump --username=%s %s > %s',
            $usuario,
            $db,
            $completo
        ));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('El backup a empezado');
            $this->process->mustRun();
            $this->info('El backup fue procesado correctamente.');
        } catch (ProcessFailedException $exception) {
            logger()->error('Backup excepcion', compact('exception'));
            $this->error('EL proceso de backup ha fallado.');
        }
        return 0;
    }
}
