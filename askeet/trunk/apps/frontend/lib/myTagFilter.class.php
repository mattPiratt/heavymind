<?php

/**
 * myTagFilter class.
 *
 * @package    askeet
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: myTagFilter.class.php 49 2005-12-17 18:51:08Z fabien $
 */
class myTagFilter extends sfFilter
{
  /**
    * Execute this filter.
    *
    * @param FilterChain The filter chain.
    *
    * @return void
    * @throws <b>FilterException</b> If an erro occurs during execution.
    */
  public function execute ($filterChain)
  {
    static $loaded;

    // execute this filter only once
    if (sfConfig::get('app_universe') && !isset($loaded))
    {
      // load the filter
      $loaded = true;

      // is there a tag in the hostname?
      $request  = $this->getContext()->getRequest();
      $hostname = $request->getHost();
      if (!preg_match($this->getParameter('host_exclude_regex'), $hostname) && $pos = strpos($hostname, '.'))
      {
        $tag = Tag::normalize(substr($hostname, 0, $pos));

        // add a permanent tag constant
        define('APP_PERMANENT_TAG', $tag);

        // add a custom stylesheet
        $request->setAttribute('app/tag_filter', $tag, 'helper/asset/auto/stylesheet');
      }
    }

    // execute next filter
    $filterChain->execute();
  }
}

?>