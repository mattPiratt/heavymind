<?php

class myTagFilter extends sfFilter
{
  public function execute ($filterChain)
  {
    // execute this filter only once
    if (sfConfig::get('app_universe') && $this->isFirstCall())
    {
      // is there a tag in the hostname?
      $hostname = $this->getContext()->getRequest()->getHost();
      if (!preg_match($this->getParameter('host_exclude_regex'), $hostname) && $pos = strpos($hostname, '.'))
      {
        $tag = Tag::normalize(substr($hostname, 0, $pos));

        // add a permanent tag custom configuration parameter
        sfConfig::set('app_permanent_tag', $tag);

        // add a custom stylesheet
        $this->getContext()->getResponse()->addStylesheet($tag);
      }

    }

    // execute next filter
    $filterChain->execute();
  }
}

?>