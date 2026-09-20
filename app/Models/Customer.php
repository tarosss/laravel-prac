<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Customer extends Model implements
  AuthenticatableContract,
  AuthorizableContract
{
  use Authenticatable, Authorizable;

  protected $table = 'customers'; // テーブル名が customers の場合
  public $timestamps = null;
    // 主キーが id 以外（例: customer_id）の場合は明示
    // protected $primaryKey = 'customer_id';

  /**
   * パスワードカラム名が `password` 以外（例: `cust_password`）の場合のみ定義
   */
  public function getAuthPassword()
  {
    return $this->cust_password;
  }

  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
  ];
}
