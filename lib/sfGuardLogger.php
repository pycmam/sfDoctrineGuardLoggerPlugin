<?php
/**
 * Event logger
 */

class sfGuardLogger
{
  /**
   * @static
   * @param sfEvent $event
   * @return void
   */
  static public function listenToApplicationLog(sfEvent $event)
  {
    $subject = $event->getSubject();
    $context = sfContext::getInstance();

    if ($subject instanceof sfAction &&
        $subject->getUser()->isAuthenticated()) {

      $request = $context->getRequest();

      if (self::hasKeywords($request->getUri()) ||
          in_array(strtolower($request->getMethod()), sfConfig::get('app_sf_guard_logger_methods'))) {

        $log = new sfGuardLog;
        $log->setUser($subject->getUser()->getGuardUser());
        $log->setUrl($request->getUri());
        $log->setApplication($context->getConfiguration()->getApplication());
        $log->setModule($context->getModuleName());
        $log->setAction($context->getActionName());
        $log->setMethod($request->getMethod());
        $log->setParams($request->getParameterHolder()->getAll());
        $log->save();

        $context->set('guardLog', $log);
      }
    } else
    if ($subject instanceof sfWebResponse &&
        $context->has('guardLog')) {

      $log = $context->get('guardLog');
      $log->setStatusCode($subject->getStatusCode());
      $log->save();
    }
  }

  /**
   * @static
   * @param $url
   * @return bool|int
   */
  static protected function hasKeywords($url)
  {
    $keywords = sfConfig::get('app_sf_guard_logger_keywords', array());
    if (count($keywords)) {
      $pattern = sprintf('/%s/i', join('|', $keywords));
      return preg_match($pattern, $url);
    }

    return false;
  }
}