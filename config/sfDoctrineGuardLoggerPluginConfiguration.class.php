<?php

class sfDoctrineGuardLoggerPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    if (sfConfig::get('app_sf_guard_logger_enabled')) {
      $this->dispatcher->connect('application.log', array('sfGuardLogger', 'listenToApplicationLog'));
    }
  }
}