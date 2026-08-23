<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // 1. 継承元を変更
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
  use Notifiable;

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
