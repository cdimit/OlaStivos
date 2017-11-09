<?php

namespace App\Traits;

trait Linkable
{

  public function removeLinks()
  {
    foreach($this->links as $link){
      $link->delete();
    }
  }

}
