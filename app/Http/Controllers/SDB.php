<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SDB {
  public static function db() {
    $l_school_id = Auth::user()->school_id;
    $db='clevproc_'.$l_school_id;//set db name
    return $db;
  }
}
