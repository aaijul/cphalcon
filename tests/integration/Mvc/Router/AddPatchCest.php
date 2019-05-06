<?php
declare(strict_types=1);

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Integration\Mvc\Router;

use IntegrationTester;
use Phalcon\Mvc\Router;
use Phalcon\Test\Fixtures\Traits\RouterTrait;

/**
 * Class AddPatchCest
 */
class AddPatchCest
{
    use RouterTrait;

    /**
     * Tests Phalcon\Mvc\Router :: addPatch()
     *
     * @param IntegrationTester $I
     *
     * @author Sid Roberts <sid@sidroberts.co.uk>
     * @since  2019-04-17
     */
    public function mvcRouterAddPatch(IntegrationTester $I)
    {
        $I->wantToTest('Mvc\Router - addPatch()');

        $router = $this->getRouter(false);

        $router->addPatch(
            '/docs/index',
            [
                'controller' => 'documentation4',
                'action'     => 'index',
            ]
        );



        $_SERVER['REQUEST_METHOD'] = 'PATCH';

        $router->handle('/docs/index');



        $I->assertEquals(
            'documentation4',
            $router->getControllerName()
        );

        $I->assertEquals(
            'index',
            $router->getActionName()
        );

        $I->assertEquals(
            [],
            $router->getParams()
        );
    }
}