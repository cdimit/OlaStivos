<?php

namespace App\Traits;

trait LinkHelper
{

  public function removeLinks()
  {
    foreach($this->links as $link){
      $link->delete();
    }
  }

}
