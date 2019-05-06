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

namespace Phalcon\Test\Unit\Logger\Adapter\Stream;

use Phalcon\Logger\Adapter\Stream;
use UnitTester;

/**
 * @package Phalcon\Test\Unit\Logger
 */
class RollbackCest
{
    /**
     * Tests Phalcon\Logger\Adapter\Stream :: rollback()
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function loggerAdapterStreamRollback(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - rollback()');

        $fileName = $I->getNewFileName('log', 'log');

        $outputPath = outputFolder('tests/logs/');

        $adapter = new Stream(
            $outputPath . $fileName
        );

        $adapter->begin();

        $I->assertTrue(
            $adapter->inTransaction()
        );

        $adapter->rollback();

        $I->assertFalse(
            $adapter->inTransaction()
        );

        $I->safeDeleteFile(
            $outputPath . $fileName
        );
    }
}