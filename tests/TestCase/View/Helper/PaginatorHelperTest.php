<?php
/**
 * This file is part of me-tools.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Mirko Pagliai
 * @link        https://github.com/mirko-pagliai/me-tools
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace MeTools\Test\TestCase\View\Helper;

use Cake\View\View;
use MeTools\TestSuite\TestCase;
use MeTools\View\Helper\PaginatorHelper;

/**
 * PaginatorHelperTest class
 */
class PaginatorHelperTest extends TestCase
{
    /**
     * @var \MeTools\View\Helper\PaginatorHelper
     */
    protected $Paginator;

    /**
     * Setup the test case, backup the static object values so they can be
     * restored. Specifically backs up the contents of Configure and paths in
     *  App if they have not already been backed up
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Paginator = new PaginatorHelper(new View());
    }

    /**
     * Tests for `next()` method
     * @return void
     * @test
     */
    public function testNext()
    {
        $result = $this->Paginator->next('Next');
        $expected = [
            'li' => ['class' => 'next page-item disabled'],
            'a' => ['class' => 'page-link', 'href' => '', 'onclick' => 'return false;'],
            'Next',
            '/a',
            '/li',
        ];
        $this->assertHtml($expected, $result);

        //Using `icon` option
        $result = $this->Paginator->next('Next', ['icon' => 'chevron-right']);
        $expected = [
            'li' => ['class' => 'next page-item disabled'],
            'a' => ['class' => 'page-link', 'href' => '', 'onclick' => 'return false;'],
            'Next',
            ' ',
            'i' => ['class' => 'fa fa-chevron-right'],
            ' ',
            '/i',
            '/a',
            '/li',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Tests for `prev()` method
     * @return void
     * @test
     */
    public function testPrev()
    {
        $result = $this->Paginator->prev('Previous');
        $expected = [
            'li' => ['class' => 'prev page-item disabled'],
            'a' => ['class' => 'page-link', 'href' => '', 'onclick' => 'return false;'],
            'Previous',
            '/a',
            '/li',
        ];
        $this->assertHtml($expected, $result);

        //Using `icon` option
        $result = $this->Paginator->prev('Previous', ['icon' => 'chevron-left']);
        $expected = [
            'li' => ['class' => 'prev page-item disabled'],
            'a' => ['class' => 'page-link', 'href' => '', 'onclick' => 'return false;'],
            'i' => ['class' => 'fa fa-chevron-left'],
            ' ',
            '/i',
            ' ',
            'Previous',
            '/a',
            '/li',
        ];
        $this->assertHtml($expected, $result);
    }
}
