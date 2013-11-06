<?php

namespace Cnerta\BreadcrumbBundle\Twig;

use RecursiveIteratorIterator;
use ArrayIterator;
use Knp\Menu\Iterator\RecursiveItemIterator;
use Knp\Menu\ItemInterface;
use Knp\Menu\Renderer\RendererProviderInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Knp\Menu\Iterator\CurrentItemFilterIterator;
use Knp\Menu\Util\MenuManipulator;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;


/**
 * Helper class containing logic to retrieve and render breadcrumb from templating engines
 *
 */
class Helper
{

    private $rendererProvider;
    private $menuProvider;

    /**
     * @var \Knp\Menu\Util\MenuManipulator
     */
    protected $menuManipulator;

    /**
     * @var \Knp\Menu\Matcher\Matcher
     */
    protected $matcher;

   /**
    *
    * @param \Knp\Menu\Renderer\RendererProviderInterface $rendererProvider
    * @param \Knp\Menu\Provider\MenuProviderInterface $menuProvider
    * @param \Knp\Menu\Matcher\Matcher $matcher
    */
    public function __construct(RendererProviderInterface $rendererProvider, MenuProviderInterface $menuProvider = null, Matcher $matcher)
    {
        $this->rendererProvider = $rendererProvider;
        $this->menuProvider = $menuProvider;
        $this->matcher = $matcher;
        $this->menuManipulator = new MenuManipulator();
    }

    /**
     * Renders an array ready to be used for breadcrumbs.
     *
     * @param ItemInterface|string $menu
     * @param array                $path
     * @param array                $options
     *
     * @return ItemInterface
     *
     * @throws \BadMethodCallException   when there is no menu provider and the menu is given by name
     * @throws \LogicException
     * @throws \InvalidArgumentException when the path is invalid
     */
    public function get($menu, array $path = array(), array $options = array())
    {
        if (!$menu instanceof ItemInterface) {
            if (null === $this->menuProvider) {
                throw new \BadMethodCallException('A menu provider must be set to retrieve a menu');
            }

            $menuName = $menu;
            $menu = $this->menuProvider->get($menuName, $options);

            if (!$menu instanceof ItemInterface) {
                throw new \LogicException(sprintf('The menu "%s" exists, but is not a valid menu item object. Check where you created the menu to be sure it returns an ItemInterface object.', $menuName));
            }
        }

        $treeIterator = new RecursiveIteratorIterator(
                new RecursiveItemIterator(
                new ArrayIterator(array($menu))
                ), RecursiveIteratorIterator::SELF_FIRST
        );

        $iterator = new CurrentItemFilterIterator($treeIterator, $this->matcher);

        $iterator->rewind();

        if($iterator->valid()) {
            $current= $iterator->current();
            $current->setCurrent(true);
        } else {
            // Set Current as an empty Item in order to avoid exceptions on knp_menu_get
            $current = new MenuItem('', new MenuFactory());
        }

        return $this->menuManipulator->getBreadcrumbsArray($current);
    }

    /**
     * Renders a breadcrumb with the specified renderer.
     *
     * If the argument is an array, it will follow the path in the tree to
     * get the needed item. The first element of the array is the whole menu.
     * If the menu is a string instead of an ItemInterface, the provider
     * will be used.
     *
     * @param ItemInterface|string|array $menu
     * @param array                      $options
     * @param string                     $renderer
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function render($menu, array $options = array(), $renderer = null)
    {
        if (!$menu instanceof ItemInterface) {
            $path = array();
            if (is_array($menu)) {
                if (empty($menu)) {
                    throw new \InvalidArgumentException('The array cannot be empty');
                }
                $path = $menu;
                $menu = array_shift($path);
            }

            $menu = $this->get($menu, $path);
        }

        return $this->rendererProvider->get($renderer)->render($menu, $options);
    }
}
