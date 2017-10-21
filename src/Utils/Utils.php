<?php

namespace Peto16\Utils;

use Anax\Page\PageRenderInterface;
use Anax\DI\InjectionAwareInterface;
use Anax\DI\InjectionAwareTrait;

/**
 * Utility class for anax.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class Utils implements PageRenderInterface, InjectionAwareInterface
{
    use InjectionAwareTrait;



    /**
     * Render a standard web page using a specific layout.
     *
     * @param array   $data   variables to expose to layout view.
     * @param integer $status code to use when delivering the result.
     *
     * @return void
     */
    public function renderPage($data, $status = 200)
    {
        $data["stylesheets"] = [
            "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css",
            "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
            "css/style.min.css",
        ];
        $data["javascripts"] = [
            "https://code.jquery.com/jquery-3.2.1.slim.min.js",
            "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js",
        ];

        // Get view object.
        $view = $this->di->get("view");

        // Add common header, navbar and footer views.
        $view->add("layout/navbar", [], "navbar");
        $view->add("layout/footer", [], "footer");

        $view->add("layout/layout", $data, "layout");
        $body = $view->renderBuffered("layout");

        $this->di->get("response")->setBody($body)->send($status);
        exit;
    }



    /**
     * Redirect to the given path.
     * @param  string       $path The given path.
     * @return void
     */
    public function redirect($path)
    {
        $url = $this->di->get("url")->create($path);
        $this->di->get("response")->redirect($url);
        exit;
    }



    /**
     * Sets frontpage banner and block.
     * @return void
     */
    public function frontpage()
    {
        $view = $this->di->get("view");

        // Add Banner region and block.
        $view->add("layout/header", [], "header");
        $view->add("block/header-me", [], "header-block");
    }
}
