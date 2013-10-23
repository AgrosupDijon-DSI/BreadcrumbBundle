<?php

namespace Cnerta\BreadcrumbBundle\Voter;

use Knp\Menu\Matcher\Voter\UriVoter;
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Voter based on the route
 */
class RouteVoter extends UriVoter implements VoterInterface
{

    /**
     * @var Request
     */
    private $request;

    function __construct()
    {
        parent::__construct(null);
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function matchItem(ItemInterface $item)
    {
        parent::setUri($this->request->getRequestUri());
//        echo "<pre>:";
//        var_dump($this->request->());
//        var_dump($item->getUri());
//        var_dump(parent::matchItem($item));
//        echo "</pre>";
        return parent::matchItem($item);
    }

}
