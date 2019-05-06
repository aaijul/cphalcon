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

namespace Phalcon\Test\Integration\Forms\Element\Text;

use IntegrationTester;
use Phalcon\Forms\Element\Text;
use Phalcon\Tag;
use Phalcon\Test\Fixtures\Traits\DiTrait;

class SetLabelCest
{
    use DiTrait;

    public function _before(IntegrationTester $I)
    {
        $this->newDi();
        $this->setDiEscaper();
        $this->setDiUrl();
    }

    /**
     * executed after each test
     */
    public function _after(IntegrationTester $I)
    {
        // Setting the doctype to XHTML5 for other tests to run smoothly
        Tag::setDocType(
            Tag::XHTML5
        );
    }

    public function testFormElementEmpty(IntegrationTester $I)
    {
        $element = new Text("name");

        $I->assertNull(
            $element->getLabel()
        );
    }

    public function testIssue1210(IntegrationTester $I)
    {
        $element = new Text("test");

        $element->setLabel("Test");

        $I->assertEquals(
            '<label for="test">Test</label>',
            $element->label()
        );
    }
}