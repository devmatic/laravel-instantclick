<?php

namespace Devmatic\InstantClick\Test;

use Illuminate\Http\Request;
use Devmatic\InstantClick\Middleware\FilterIfInstantClick;
use Symfony\Component\HttpFoundation\Response;

class FilterIfInstantClickTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->middleware = new FilterIfInstantClick();
    }

    /** @test */
    public function it_will_not_modify_a_non_instantclick_request()
    {
        $request = new Request();

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertFalse($this->isInstantClickReponse($response));

        $this->assertEquals($this->getHtml(), $response->getContent());
    }

    /** @test */
    public function it_will_return_the_title_and_contents_of_the_container_for_instantclick_request()
    {
        $request = $this->addInstantClickHeaders(new Request());

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertTrue($this->isInstantClickReponse($response));

        $this->assertEquals("<title>InstantClick title</title>\n        <div>Content</div>\n    ", $response->getContent());
    }

    /** @test */
    public function it_will_not_return_the_title_if_it_is_not_set()
    {
        $request = $this->addInstantClickHeaders(new Request());

        $response = $this->middleware->handle($request, $this->getNext('pageWithoutTitle'));

        $this->assertTrue($this->isInstantClickReponse($response));

        $this->assertEquals("\n        <div>Content</div>\n    ", $response->getContent());
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return bool
     */
    protected function isInstantClickReponse(Response $response)
    {
        return $response->headers->has('X-INSTANTCLICK');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Request
     */
    protected function addInstantClickHeaders(Request $request)
    {
        $request->headers->set('X-INSTANTCLICK', true);

        return $request;
    }

    /**
     * @param string $pageName
     *
     * @return \Closure
     */
    protected function getNext($pageName = 'pageWithTitle')
    {
        $html = $this->getHtml($pageName);

        $response = (new \Illuminate\Http\Response($html));

        return function ($request) use ($response) {

            return $response;
        };
    }

    /**
     * @param string $pageName
     *
     * @return string
     */
    protected function getHtml($pageName = 'pageWithTitle')
    {
        return file_get_contents(__DIR__."/fixtures/{$pageName}.html");
    }
}
