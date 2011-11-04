<?php

/**
 * PluginsfGuardLog
 */
abstract class PluginsfGuardLog extends BasesfGuardLog
{
  /**
   * Set params
   *
   * @param array $params
   * @return void
   */
  public function setParams(array $params)
  {
    $this->_set('params', serialize($params));
  }

  /**
   * Get params
   *
   * @return array|null
   */
  public function getParams()
  {
    $params = $this->_get('params');
    return $params ? unserialize($params) : null;
  }
}