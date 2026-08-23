<?php

namespace App\Classes;

class Article
{
  public int $authorId;
  public function __construct(int $authorId)
  {
    $this->authorId = $authorId;
  }
}
