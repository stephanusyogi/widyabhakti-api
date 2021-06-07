<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable implements JWTSubject
{
    //
    use Notifiable;
    protected $table = 'table_user';
    public $timestamps = false;

    protected $fillable = [
      'id_user',
      'name',
      'email',
      'username',
      'password',
      'organisasi',
      'nohp',
      'created_at'
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
