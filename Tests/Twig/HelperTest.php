<?php

namespace Cnerta\BreadcrumbBundle\Tests\Templating;

use Cnerta\BreadcrumbBundle\Twig\Helper;
use Knp\Bundle\MenuBundle\Provider\BuilderAliasProvider;

/**
 * Test for MenuHelper class
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException LogicException
     */
    public function testFailGet()
    {
        $rendererProviderMock = $this->getMockBuilder('Knp\Menu\Renderer\RendererProviderInterface')
                ->disableOriginalConstructor()
                ->getMock();
        

        $menuProviderMock = $this->getMockBuilder('Knp\Menu\Provider\MenuProviderInterface')
                ->disableOriginalConstructor()
                ->getMock();

        $matcherMock = $this->getMockBuilder('Knp\Menu\Matcher\Matcher')
                ->disableOriginalConstructor()
                ->getMock();

        $helper = new Helper($rendererProviderMock, $menuProviderMock, $matcherMock);

        $this->assertEquals($helper->get("bleu"), 'The menu "bleu" exists, but is not a valid menu item object. Check where you created the menu to be sure it returns an ItemInterface object.');
    }

}
