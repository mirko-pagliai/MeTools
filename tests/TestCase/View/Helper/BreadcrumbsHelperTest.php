<?php
/**
 * This file is part of MeTools.
 *
 * MeTools is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * MeTools is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with MeTools.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Mirko Pagliai <mirko.pagliai@gmail.com>
 * @copyright   Copyright (c) 2016, Mirko Pagliai for Nova Atlantis Ltd
 * @license     http://www.gnu.org/licenses/agpl.txt AGPL License
 * @link        http://git.novatlantis.it Nova Atlantis Ltd
 */
namespace MeTools\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use MeTools\View\Helper\BreadcrumbsHelper;

/**
 * MeTools\View\Helper\BreadcrumbsHelper Test Case
 */
class BreadcrumbsHelperTest extends TestCase
{
    /**
     * @var \MeTools\View\Helper\BreadcrumbsHelper
     */
    protected $Breadcrumbs;

    /**
     * Setup the test case, backup the static object values so they can be
     * restored. Specifically backs up the contents of Configure and paths in
     *  App if they have not already been backed up
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->View = new View();
        $this->Breadcrumbs = new BreadcrumbsHelper($this->View);
    }

    /**
     * Teardown any static object changes and restore them
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->Breadcrumbs, $this->View);
    }

    /**
     * Tests for `render()` method
     * @test
     */
    public function testRender()
    {
        $this->assertSame('', $this->Breadcrumbs->render());

        $this->Breadcrumbs->add('First', '/');
        $this->Breadcrumbs->add('Second', '/');

        $result = $this->Breadcrumbs->render();
        $expected = [
            'ul' => ['class' => 'breadcrumb'],
            ['li' => []],
            'a' => ['href' => '/'],
            'First',
            '/a',
            '/li',
            ['li' => []],
            'span' => [],
            'Second',
            '/span',
            '/li',
            '/ul',
        ];
        $this->assertHtml($expected, $result);
    }
}
