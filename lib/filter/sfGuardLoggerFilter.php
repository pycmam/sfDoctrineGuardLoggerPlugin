<?php

class sfGuardLoggerFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $user = $this->getContext()->getUser();



    $filterChain->execute();
  }
}