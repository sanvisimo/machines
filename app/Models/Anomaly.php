<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anomaly extends Model
{
    use HasFactory;

  /**
   * Get the machine that owns the comment.
   */
  public function machine()
  {
    return $this->belongsTo(Machine::class);
  }

  public function control_plan()
  {
    return $this->belongsTo(ControlPlan::class);
  }
}
