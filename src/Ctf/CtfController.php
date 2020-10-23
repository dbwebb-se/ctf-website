<?php

namespace Anax\Ctf;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\Commons\ContainerInjectableInterface;
use \Anax\Commons\ContainerInjectableTrait;

/**
 * A controller class.
 */
class CtfController
    implements ConfigureInterface,
               ContainerInjectableInterface
{
    use ConfigureTrait,
        ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * This is how a general helper method can be created in the controller.
     *
     * @param string $method as the method that handled the controller
     *                       action.
     * @param array  $args   as an array of arguments.
     *
     * @return string as a message to output to help understand how the
     *                controller method works.
     */
    public function getDetailsOnRequest(
        string $method,
        array $args = []
    ) : string
    {
        $request     = $this->di->get("request");
        $path        = $request->getRoute();
        $httpMethod  = $request->getMethod();
        $numArgs     = count($args);
        $strArgs     = implode(", ", $args);
        $queryString = http_build_query($request->getGet(), '', ', ');

        return <<<EOD
            <h1>$method</h1>

            <p>The request was '$path' ($httpMethod).
            <p>Got '$numArgs' arguments: '$strArgs'.
            <p>Query string contains: '$queryString'.
            <p>\$db is '{$this->db}'.
        EOD;
    }



    /**
     * Show all ctf's.
     *
     * @return object response to render.
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $db = $this->di->get("db");

        $db->connect();
        $sql = "SELECT id, title, author FROM ctf";
        $res = $db->executeFetchAll($sql);

        $data = [
            "content" => "<pre>" . print_r($res, 1) . "</pre>",
        ];
        $page->add("anax/v2/article/default", $data);

        return $page->render([
            "title" => __METHOD__,
        ]);
    }



    /**
     * Show a single ctf.
     *
     * @return object response to render.
     */
    public function idAction($id) : object
    {
        $page = $this->di->get("page");
        $db = $this->di->get("db");

        $db->connect();
        $sql = "SELECT * FROM ctf WHERE id = ?";
        $res = $db->executeFetch($sql, [$id]);
        $sql = "SELECT * FROM ctf2tag WHERE ctf_id = ?";
        $tag = $db->executeFetchAll($sql, [$id]);

        $data = [
            "ctf" => $res,
            "tags" => $tag,
        ];
        $page->add("ctf/one", $data);

        return $page->render([
            "title" => "CTF - '"
                . ($res->title ?? "No title")
                . "'",
        ]);
    }



    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     *  ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return object response to render.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args) : object
    {
        $page    = $this->di->get("page");

        $data = [
            "content" => $this->getDetailsOnRequest(__METHOD__, $args),
        ];
        $page->add("anax/v2/article/default", $data);

        return $page->render([
            "title" => __METHOD__,
        ]);
    }
}
