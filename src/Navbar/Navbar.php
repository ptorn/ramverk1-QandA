<?php
namespace Peto16\Navbar;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Common\ConfigureInterface;
use \Anax\Common\ConfigureTrait;

/**
 * Navbar class.
 *
 */
class Navbar implements ConfigureInterface, InjectionAwareInterface
{
    use ConfigureTrait;
    use InjectionAwareTrait;



    /**
     * Check if item matches current route
     * @param  array        $item [array item from navbar config]
     * @return boolean       returns true or false.
     */
    public function isActiveLink($item)
    {
        $currentUrl = $this->di->get("request")->getRoute();
        return $currentUrl === $item['route'];
    }



    /**
     * Generate menu items and return the menu items array.
     * @param string        Name of menu. Default is navbar
     * @return array        Array containing menu items.
     */
    public function routes($menu = "navbar")
    {
        $result = $this->createNavRoutes($this->config[$menu]);
        if ($this->isLoggedIn()) {
            return array_filter($result, function ($item) {
                return $item['route'] != "user/login";
            });
        }
        return array_filter($result, function ($item) {
            return $item['route'] != "admin";
        });
    }



    /**
     * Create all routes in navigation and sublevels. With generated url.
     * @param  array        $level array with menu items.
     * @return array        Return a array with prepared link items.
     */
    private function createNavRoutes($level)
    {
        // Prepare Menu array to only show certain items for logged in users.
        $level['items'] = array_filter($level['items'], function ($item) {
            if ($item['available'] === "administrator" &&
                $this->isLoggedIn() === false) {
                return false;
            }
            return true;
        });
        return array_map(function ($item) {
            if (array_key_exists("submenu", $item)) {
                return [
                    "title"     => $item['title'],
                    "icon"      => $item['icon'],
                    "route"     => $item['route'],
                    "available" => $item['available'],
                    "url"       => $this->di->get("url")->create($item['route']),
                    "submenu"   => $this->createNavRoutes($item['submenu'])
                ];
            }
            return [
                "title" => $item['title'],
                "icon"  => $item['icon'],
                "route" => $item['route'],
                "available" => $item['available'],
                "url"   => $this->di->get("url")->create($item['route'])
            ];
        }, $level['items']);
    }



    /**
     * Create a navigation and a view and asign a region
     * @param  string       $template path to template file
     * @param  string       $region   region to be asigned to.
     * @return region       Name of region created
     */
    public function createNav($template, $region)
    {
        $this->di->get("view")->add($template, [], $region);
        return $region;
    }



    /**
     * Check if a user is logged in or not.
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        if ($this->di->get('session')->has('user') != null) {
            return true;
        }
        return false;
    }
}
