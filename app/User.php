<?php

namespace App;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'email', 'password','estado','rol','correo_validado','usr_id_creador','celular','direccion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function productores() {
        return $this->hasMany(\App\Models\Productor::class, 'usr_id', 'id');
    }
    public function valoraciones() {
        return $this->hasMany(\App\Models\ValoracionProductor::class, 'usr_id', 'id');
    }

    public function mensajesUsuarioEmisor() {
        return $this->hasMany(\App\Models\MensajeUsuario::class, 'usr_id_e', 'id');
    }

    public function mensajesUsuarioReceptor() {
        return $this->hasMany(\App\Models\MensajeUsuario::class, 'usr_id_r', 'id');
    }

    public function ventas() {
        return $this->hasMany(\App\Models\Venta::class, 'usr_id', 'id');
    }

    public function carritos() {
        return $this->hasMany(\App\Models\Carrito::class, 'usr_id', 'id');
    }

    public function FeriaCertificados() {
        return $this->hasMany(\App\Models\FeriaCertificado::class, 'usr_id', 'id');
    }

    public function CertificadosEmitidos() {
        return $this->hasMany(\App\Models\CertificadoEmitido::class, 'usr_id', 'id');
    }

    public function valoracionesProducto() {
        return $this->hasMany(\App\Models\ValoracionProducto::class, 'usr_id', 'id');
    }

    public function denuncias() {
        return $this->hasMany(\App\Models\Denuncia::class, 'usr_id', 'id');
    }

    public function feriaProductores() {
        return $this->hasMany(\App\Models\FeriaProductor::class, 'usr_id', 'id');
    }

}
