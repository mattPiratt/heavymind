<?php

function pager_navigation($pager, $uri)
{
  $navigation = '';
 
  if ($pager->haveToPaginate())
  {  
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';

    // First and previous page
    $navigation .= link_to('&laquo;', $uri.'1');
    $navigation .= link_to('&lt;', $uri.$pager->getPreviousPage());

    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
    }
    $navigation .= join(' - ', $links);

    // Next and last page
    $navigation .= link_to('&gt;', $uri.$pager->getNextPage());
    $navigation .= link_to('&raquo;', $uri.$pager->getLastPage());
  }

  return $navigation;
}

function link_to_feed($name, $uri)
{
  return link_to(image_tag('rss.gif', array('alt' => $name, 'title' => $name, 'align' => 'absmiddle')), $uri);
}
?>