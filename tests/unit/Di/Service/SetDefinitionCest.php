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

namespace Phalcon\Test\Unit\Di\Service;

use UnitTester;

class SetDefinitionCest
{
    /**
     * Tests Phalcon\Di\Service :: setDefinition()
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function diServiceSetDefinition(UnitTester $I)
    {
        $I->wantToTest('Di\Service - setDefinition()');

        $I->skipTest('Need implementation');
    }
}