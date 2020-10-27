<?php

namespace Anax\Ctf;

use Anax\Configure\ConfigureInterface;
use Anax\Configure\ConfigureTrait;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Route\Exception\NotFoundException;

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
        $sql = "SELECT * FROM ctf";
        $res = $db->executeFetchAll($sql);

        $data = [
            "ctfs" => $res,
        ];
        $page->add("ctf/all", $data);

        return $page->render([
            "title" => "CTF @ dbwebb ",
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
        $sql = "SELECT * FROM hint WHERE ctf_id = ?";
        $hint = $db->executeFetchAll($sql, [$id]);

        $data = [
            "ctf" => $res,
            "tags" => $tag,
            "hints" => $hint,
        ];
        $page->add("ctf/one", $data);

        return $page->render([
            "title" => "CTF - '"
                . ($res->title ?? "No title")
                . "'",
        ]);
    }



    /**
     * Download a target for a CTF.
     *
     * @return object response to render.
     */
    public function targetAction($targetId) : object
    {
        $base = realpath(ANAX_INSTALL_PATH . "/data/ctf/target");
        $target = realpath("$base/$targetId");

        if (substr_compare($target, $base, 0, strlen($base))) {
            // Security, trying to mix with the base?
            throw new NotFoundException("No such target exists.");
        } elseif(!is_readable($target)) {
            throw new NotFoundException("No such target exists.");
        }

        return $this->di->get("response")->addFile($target);
    }



    /**
     * Show a hint for a ctf.
     *
     * @return object response to render.
     */
    public function hintAction($ctfId, $hintId) : object
    {
        $page = $this->di->get("page");
        $db = $this->di->get("db");

        $db->connect();
        $sql = "SELECT * FROM ctf WHERE id = ?";
        $res = $db->executeFetch($sql, [$ctfId]);
        $sql = "SELECT * FROM hint WHERE ctf_id = ? AND id = ?";
        $hint = $db->executeFetch($sql, [$ctfId, $hintId]);

        $data = [
            "ctf" => $res,
            "hint" => $hint,
        ];
        $page->add("ctf/hint", $data);

        return $page->render([
            "title" => "CTF hint - '"
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
        // $title = $args[0] ?? null;
        //
        // if (is_string($title)) {
        //     $db = $this->di->get("db");
        //     $db->connect();
        //     $sql = "SELECT * FROM ctf WHERE title = ?";
        //     $res = $db->executeFetch($sql, [$title]);
        //     if ($res->id ?? null) {
        //         return idAction($res->id);
        //     }
        // }

        $page = $this->di->get("page");
        $data = [
            "content" => $this->getDetailsOnRequest(__METHOD__, $args),
        ];
        $page->add("anax/v2/article/default", $data);

        return $page->render([
            "title" => __METHOD__,
        ]);
    }
}
