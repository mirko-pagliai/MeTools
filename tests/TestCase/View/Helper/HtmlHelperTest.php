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
use MeTools\View\Helper\HtmlHelper;

/**
 * HtmlHelperTest class
 */
class HtmlHelperTest extends TestCase
{
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
        $this->Html = new HtmlHelper($this->View);
    }

    /**
     * Teardown any static object changes and restore them
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->Html, $this->View);
    }

    /**
     * Tests for `__call()` method
     * @return void
     * @test
     */
    public function testMagicCall()
    {
        $text = 'my h3 text';
        $class = 'my-class';

        //The `h3()` method should not exist, otherwise the `__call()` method
        //  will not be called
        $this->assertFalse(method_exists($this->Html, 'h3'));

        $result = $this->Html->h3($text, ['class' => $class]);
        $expected = $this->Html->tag('h3', $text, ['class' => $class]);
        $this->assertEquals($expected, $result);

        $result = $this->Html->h3($text, ['class' => $class, 'icon' => 'home']);
        $expected = $this->Html->tag(
            'h3',
            $text,
            ['class' => $class, 'icon' => 'home']
        );
        $this->assertEquals($expected, $result);

        $result = $this->Html->h3(
            $text,
            ['class' => $class, 'icon' => 'home', 'icon-align' => 'right']
        );
        $expected = $this->Html->tag(
            'h3',
            $text,
            ['class' => $class, 'icon' => 'home', 'icon-align' => 'right']
        );
        $this->assertEquals($expected, $result);
    }

    /**
     * Test for `addIcon()` method
     * @return void
     * @test
     */
    public function testAddIcon()
    {
        $text = 'My text';

        $result = $this->Html->addIcon($text, ['icon' => 'home']);
        $expected = [
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            $text,
        ];
        $this->assertHtml($expected, array_values($result)[0]);

        $result = $this->Html->addIcon($text, ['icon' => 'home', 'icon-align' => 'right']);
        $expected = [
            $text,
            ' ',
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
        ];
        $this->assertHtml($expected, array_values($result)[0]);

        //This will be only `$text`
        $result = $this->Html->addIcon($text, []);
        $this->assertEquals($text, array_values($result)[0]);

        //This will be only icon
        $result = $this->Html->addIcon(null, ['icon' => 'home']);
        $expected = ['i' => ['class' => 'fa fa-home'], ' ', '/i'];
        $this->assertHtml($expected, array_values($result)[0]);
    }

    /**
     * Test for `addTooltip()` method
     * @return void
     * @test
     */
    public function testAddTooltip()
    {
        $tooltip = 'My tooltip';

        $expected = ['data-toggle' => 'tooltip', 'title' => $tooltip];

        $result = $this->Html->addTooltip(['tooltip' => $tooltip]);
        $this->assertEquals($expected, $result);

        // `tooltip` rewrites `title`
        $result = $this->Html->addTooltip([
            'title' => 'my title',
            'tooltip' => $tooltip,
        ]);
        $this->assertEquals($expected, $result);

        $result = $this->Html->addTooltip([
            'data-toggle' => 'some-data-here',
            'tooltip' => $tooltip,
        ]);
        $expected = [
            'data-toggle' => 'some-data-here tooltip',
            'title' => $tooltip,
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests for `badge()` method
     * @return void
     * @test
     */
    public function testBadge()
    {
        $text = 'My text';

        $result = $this->Html->badge($text);
        $expected = [
            'span' => ['class' => 'badge'],
            $text,
            '/span',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->badge($text, ['class' => 'my-class']);
        $expected = [
            'span' => ['class' => 'my-class badge'],
            $text,
            '/span',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `button()` method
     * @return void
     * @test
     */
    public function testButton()
    {
        $text = 'My text';

        $result = $this->Html->button($text);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => $text,
            ],
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, null, ['title' => 'my-custom-title']);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => 'my-custom-title',
            ],
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, null, ['class' => 'my-class']);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'my-class btn btn-default',
                'title' => $text,
             ],
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, null, ['class' => 'btn-primary']);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn-primary btn',
                'title' => $text,
            ],
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, null, ['tooltip' => 'my tooltip']);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'data-toggle' => 'tooltip',
                'title' => 'my tooltip',
            ],
            $text,
            '/button'
        ];
        $this->assertHtml($expected, $result);

        // `tooltip` value rewrites `title` value
        $result = $this->Html->button(
            $text,
            null,
            ['title' => 'my custom title', 'tooltip' => 'my tooltip']
        );
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'data-toggle' => 'tooltip',
                'title' => 'my tooltip',
            ],
            $text,
            '/button'
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, null, ['icon' => 'home']);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => $text,
             ],
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);

        //Single quote on text
        $result = $this->Html->button('Single quote \'', null);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => 'Single quote &#039;',
            ],
            'Single quote \'',
            '/button',
        ];
        $this->assertHtml($expected, $result);

        //Double quote on text
        $result = $this->Html->button('Double quote "', null);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => 'Double quote &quot;',
             ],
            'Double quote "',
            '/button',
        ];
        $this->assertHtml($expected, $result);

        //Single quote on custom title
        $result = $this->Html->button(
            $text,
            null,
            ['title' => 'Single quote \'']
        );
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => 'Single quote &#039;',
            ],
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);

        //Double quote on custom title
        $result = $this->Html->button(
            $text,
            null,
            ['title' => 'Double quote "']
        );
        $expected = [
            'button' => [
                'title' => 'Double quote &quot;',
                'role' => 'button',
                'class' => 'btn btn-default',
            ],
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);

        //Code on text
        $result = $this->Html->button('<u>Code</u> and text', null);
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => 'Code and text',
            ],
            'u' => true,
            'Code',
            '/u',
            ' and text',
            '/button',
        ];
        $this->assertHtml($expected, $result);

        //Code on custom title
        $result = $this->Html->button(
            $text,
            null,
            ['title' => '<u>Code</u> and text']
        );
        $expected = [
            'button' => [
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => 'Code and text'
            ],
            $text,
            '/button',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `button()` method, with buttons as links
     * @return void
     * @test
     */
    public function testButtonAsLink()
    {
        $text = 'My text';

        $result = $this->Html->button($text, '#');
        $expected = [
            'a' => [
                'href' => '#',
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => $text,
            ],
            $text,
            '/a',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, '#', ['class' => 'my-class']);
        $expected = [
            'a' => [
                'href' => '#',
                'role' => 'button',
                'class' => 'my-class btn btn-default',
                'title' => $text,
            ],
            $text,
            '/a',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, '#', ['class' => 'btn-primary']);
        $expected = [
            'a' => [
                'href' => '#',
                'role' => 'button',
                'class' => 'btn-primary btn',
                'title' => $text,
            ],
            $text,
            '/a',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, '#', ['tooltip' => 'my tooltip']);
        $expected = [
            'a' => [
                'href' => '#',
                'role' => 'button',
                'class' => 'btn btn-default',
                'data-toggle' => 'tooltip',
                'title' => 'my tooltip',
            ],
            $text,
            '/a'
        ];
        $this->assertHtml($expected, $result);

        // `tooltip` value rewrites `title` value
        $result = $this->Html->button(
            $text,
            '#',
            ['title' => 'my custom title', 'tooltip' => 'my tooltip']
        );
        $expected = [
            'a' => [
                'href' => '#',
                'role' => 'button',
                'class' => 'btn btn-default',
                'data-toggle' => 'tooltip',
                'title' => 'my tooltip',
            ],
            $text,
            '/a'
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->button($text, '#', ['icon' => 'home']);
        $expected = [
            'a' => [
                'href' => '#',
                'role' => 'button',
                'class' => 'btn btn-default',
                'title' => $text,
            ],
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            $text,
            '/a',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `css()` method
     * @return void
     * @test
     */
    public function testCss()
    {
        //By default, `block` is `true`
        $result = $this->Html->css('my-file');
        $this->assertNull($result);

        $result = $this->Html->css('my-file2', ['block' => true]);
        $this->assertNull($result);

        $result = $this->Html->css('my-file3', ['block' => false]);
        $expected = [
            'link' => ['rel' => 'stylesheet', 'href' => '/css/my-file3.css']
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->css('my-file4', ['block' => false, 'rel' => 'alternate']);
        $expected = [
            'link' => ['rel' => 'alternate', 'href' => '/css/my-file4.css']
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `cssBlock()` method
     * @return void
     * @test
     */
    public function testCssBlock()
    {
        $css = 'body { color: red; }';

        //By default, `block` is `true`
        $result = $this->Html->cssBlock($css);
        $this->assertNull($result);

        $result = $this->Html->cssBlock($css, ['block' => true]);
        $this->assertNull($result);

        $result = $this->Html->cssBlock($css, ['block' => false]);
        $expected = ['style' => true, $css, '/style'];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `cssStart()` and `cssEnd()` methods
     * @return void
     * @test
     */
    public function testCssStartAndCssEnd()
    {
        $css = 'body { color: red; }';

        //By default, `block` is `true`
        $result = $this->Html->cssStart();
        $this->assertNull($result);

        echo $css;

        $result = $this->Html->cssEnd();
        $this->assertNull($result);

        $result = $this->Html->cssStart(['block' => true]);
        $this->assertNull($result);

        echo $css;

        $result = $this->Html->cssEnd();
        $this->assertNull($result);

        $result = $this->Html->cssStart(['block' => false]);
        $this->assertNull($result);

        echo $css;

        $result = $this->Html->cssEnd();
        $expected = ['<style', $css, '/style'];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `div()` method
     * @return void
     * @test
     */
    public function testDiv()
    {
        $expected = ['div' => true, '/div'];

        $result = $this->Html->div();
        $this->assertHtml($expected, $result);

        $result = $this->Html->div(null);
        $this->assertHtml($expected, $result);

        $result = $this->Html->div(null, null);
        $this->assertHtml($expected, $result);

        $result = $this->Html->div(null, '');
        $this->assertHtml($expected, $result);

        $expected = ['div' => ['class' => 'my-class']];

        $result = $this->Html->div('my-class');
        $this->assertHtml($expected, $result);

        $result = $this->Html->div('my-class', null);
        $this->assertHtml($expected, $result);

        $result = $this->Html->div(null, ' ');
        $expected = ['div' => true, ' ', '/div'];
        $this->assertHtml($expected, $result);

        $result = $this->Html->div(null, 'my text', ['tooltip' => 'my tooltip']);
        $expected = [
            'div' => ['data-toggle' => 'tooltip', 'title' => 'my tooltip'],
            'my text',
            '/div',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->div('my-class', 'My text', ['id' => 'my-id', 'icon' => 'home']);
        $expected = [
            'div' => ['class' => 'my-class', 'id' => 'my-id'],
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            'My text',
            '/div'
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Tests for `heading()` method
     * @return void
     * @test
     */
    public function testHeading()
    {
        $text = 'My header';
        $smallText = 'My small text';

        $expected = ['h2' => true, $text, '/h2'];

        $result = $this->Html->heading($text);
        $this->assertHtml($expected, $result);

        //It still creates a h2 tag
        $result = $this->Html->heading($text, ['type' => 'strong']);
        $this->assertHtml($expected, $result);

        $result = $this->Html->heading($text, ['type' => 'h4']);
        $expected = ['h4' => true, $text, '/h4'];
        $this->assertHtml($expected, $result);

        $result = $this->Html->heading($text, [], $smallText);
        $expected = [
            'h2' => true,
            $text,
            ' ',
            'small' => true,
            $smallText,
            '/small',
            '/h2',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->heading($text, ['type' => 'h4'], $smallText);
        $expected = [
            'h4' => true,
            $text,
            ' ',
            'small' => true,
            $smallText,
            '/small',
            '/h4',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->heading(
            $text,
            ['class' => 'header-class'],
            $smallText,
            ['class' => 'small-class']
        );
        $expected = [
            'h2' => ['class' => 'header-class'],
            $text,
            ' ',
            'small' => ['class' => 'small-class'],
            $smallText,
            '/small',
            '/h2',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `hr()` method
     * @return void
     * @test
     */
    public function testHr()
    {
        $result = $this->Html->hr();
        $expected = $this->Html->tag('hr');
        $this->assertEquals($expected, $result);

        $result = $this->Html->hr(['class' => 'my-hr-class']);
        $expected = $this->Html->tag('hr', null, ['class' => 'my-hr-class']);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test for `icon()` method
     * @return void
     * @test
     */
    public function testIcons()
    {
        $expected = [
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i'
        ];

        $result = $this->Html->icon('home');
        $this->assertHtml($expected, $result);

        $result = $this->Html->icon('fa-home');
        $this->assertHtml($expected, $result);

        $result = $this->Html->icon('fa home');
        $this->assertHtml($expected, $result);

        $result = $this->Html->icon('fa fa-home');
        $this->assertHtml($expected, $result);

        $expected = [
            'i' => ['class' => 'fa fa-hand-o-right fa-2x'],
            ' ',
            '/i'
        ];

        $result = $this->Html->icon('hand-o-right 2x');
        $this->assertHtml($expected, $result);

        $result = $this->Html->icon('hand-o-right', '2x');
        $this->assertHtml($expected, $result);

        $result = $this->Html->icon(['hand-o-right', '2x']);
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `iframe()` method
     * @return void
     * @test
     */
    public function testIframe()
    {
        $url = 'http://frame';

        $expected = ['iframe' => ['src' => $url]];

        $result = $this->Html->iframe($url);
        $this->assertHtml($expected, $result);

        //No existing ratio
        $result = $this->Html->iframe($url, ['ratio' => 'noExisting']);
        $this->assertHtml($expected, $result);

        $result = $this->Html->iframe($url, ['class' => 'my-class']);
        $expected = ['iframe' => ['class' => 'my-class', 'src' => $url]];
        $this->assertHtml($expected, $result);

        //The `src` option doesn't overwrite
        $result = $this->Html->iframe($url, ['src' => 'http://anotherframe']);
        $expected = ['iframe' => ['src' => $url]];
        $this->assertHtml($expected, $result);

        $result = $this->Html->iframe($url, ['ratio' => '16by9']);
        $expected = [
            'div' => ['class' => 'embed-responsive embed-responsive-16by9'],
            'iframe' => ['class' => 'embed-responsive-item', 'src' => $url],
            '/iframe',
            '/div',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->iframe($url, ['ratio' => '4by3']);
        $expected = [
            'div' => ['class' => 'embed-responsive embed-responsive-4by3'],
            'iframe' => ['class' => 'embed-responsive-item', 'src' => $url],
            '/iframe',
            '/div',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->iframe(
            $url,
            ['class' => 'my-class', 'ratio' => '16by9']
        );
        $expected = [
            'div' => ['class' => 'embed-responsive embed-responsive-16by9'],
            'iframe' => [
                'class' => 'my-class embed-responsive-item',
                'src' => $url,
            ],
            '/iframe',
            '/div',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `image()` and `img()` methods
     * @return void
     * @test
     */
    public function testImage()
    {
        $image = 'image.gif';

        $result = $this->Html->image($image);
        $expected = [
            'img' => [
                'src' => '/img/image.gif',
                'alt' => $image,
                'class' => 'img-responsive',
            ],
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->image($image, ['class' => 'my-class']);
        $expected = [
            'img' => [
                'src' => '/img/image.gif',
                'alt' => $image,
                'class' => 'my-class img-responsive',
            ],
        ];
        $this->assertHtml($expected, $result);

        //Tests `img()` alias
        $result = $this->Html->img($image, ['class' => 'my-class']);
        $expected = [
            'img' => [
                'src' => '/img/image.gif',
                'alt' => $image,
                'class' => 'my-class img-responsive',
            ],
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->image($image, ['alt' => 'my-alt']);
        $expected = [
            'img' => [
                'src' => '/img/image.gif',
                'alt' => 'my-alt',
                'class' => 'img-responsive',
            ],
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->image($image, ['tooltip' => 'my tooltip']);
        $expected = [
            'img' => [
                'src' => '/img/image.gif',
                'alt' => $image,
                'class' => 'img-responsive',
                'data-toggle' => 'tooltip',
                'title' => 'my tooltip',
            ],
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->image('http://fullurl/image.gif');
        $expected = [
            'img' => [
                'src' => 'http://fullurl/image.gif',
                'alt' => $image,
                'class' => 'img-responsive',
            ],
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Tests for `label()` method
     * @return void
     * @test
     */
    public function testLabel()
    {
        $text = 'My text';

        $result = $this->Html->label($text);
        $expected = [
            'span' => ['class' => 'label label-default'],
            $text,
            '/span',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->label($text, ['class' => 'my-class']);
        $expected = [
            'span' => ['class' => 'my-class label label-default'],
            $text,
            '/span',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->label($text, ['type' => 'success']);
        $expected = [
            'span' => ['class' => 'label label-success'],
            $text,
            '/span',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->label(
            $text,
            ['class' => 'my-class', 'type' => 'success']
        );
        $expected = [
            'span' => ['class' => 'my-class label label-success'],
            $text,
            '/span',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `li()` method
     * @return void
     * @test
     */
    public function testLi()
    {
        $result = $this->Html->li('My text');
        $expected = ['li' => true, 'My text', '/li'];
        $this->assertHtml($expected, $result);

        $result = $this->Html->li('My text', ['icon' => 'home']);
        $expected = [
            'li' => true,
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            'My text',
            '/li'
        ];
        $this->assertHtml($expected, $result);

        $list = ['first-value', 'second-value'];

        $result = $this->Html->li($list);
        $expected = [
            ['li' => true],
            'first-value',
            '/li',
            ['li' => true],
            'second-value',
            '/li',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->li($list, ['class' => 'my-class']);
        $expected = [
            ['li' => ['class' => 'my-class']],
            'first-value',
            '/li',
            ['li' => ['class' => 'my-class']],
            'second-value',
            '/li',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->li($list, ['icon' => 'home']);
        $expected = [
            ['li' => true],
            ['i' => ['class' => 'fa fa-home']],
            ' ',
            '/i',
            ' ',
            'first-value',
            '/li',
            ['li' => true],
            ['i' => ['class' => 'fa fa-home']],
            ' ',
            '/i',
            ' ',
            'second-value',
            '/li',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `link()` method
     * @return void
     * @test
     */
    public function testLink()
    {
        $title = 'My title';
        
        $result = $this->Html->link(
            $title,
            'http://link',
            ['title' => 'my-custom-title']
        );
        $expected = [
            'a' => ['href' => 'http://link', 'title' => 'my-custom-title'],
            $title,
            '/a',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->link($title, 'http://link', ['icon' => 'home']);
        $expected = [
            'a' => ['href' => 'http://link', 'title' => $title],
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            $title,
            '/a',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->link(
            $title,
            '#',
            ['icon' => 'home', 'icon-align' => 'right']
        );
        $expected = [
            'a' => ['href' => '#', 'title' => $title],
            $title,
            ' ',
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            '/a',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->link($title, '#', ['tooltip' => 'my tooltip']);
        $expected = [
            'a' => [
                'href' => '#',
                'data-toggle' => 'tooltip',
                'title' => 'my tooltip',
            ],
            $title,
            '/a'
        ];
        $this->assertHtml($expected, $result);

        // `tooltip` value rewrites `title` value
        $result = $this->Html->link(
            $title,
            '#',
            ['title' => 'my custom title', 'tooltip' => 'my tooltip']
        );
        $expected = [
            'a' => [
                'href' => '#',
                'data-toggle' => 'tooltip',
                'title' => 'my tooltip',
            ],
            $title,
            '/a'
        ];
        $this->assertHtml($expected, $result);

        //Single quote on text
        $result = $this->Html->link('Single quote \'', '#');
        $expected = [
            'a' => ['href' => '#', 'title' => 'Single quote &#039;'],
            'Single quote \'',
            '/a',
        ];
        $this->assertHtml($expected, $result);

        //Double quote on text
        $result = $this->Html->link('Double quote "', '#');
        $expected = [
            'a' => ['href' => '#', 'title' => 'Double quote &quot;'],
            'Double quote "',
            '/a',
        ];
        $this->assertHtml($expected, $result);

        //Single quote on custom title
        $result = $this->Html->link(
            $title,
            '#',
            ['title' => 'Single quote \'']
        );
        $expected = [
            'a' => ['href' => '#', 'title' => 'Single quote &#039;'],
            $title,
            '/a',
        ];
        $this->assertHtml($expected, $result);

        //Double quote on custom title
        $result = $this->Html->link(
            $title,
            '#',
            ['title' => 'Double quote "']
        );
        $expected = [
            'a' => ['href' => '#', 'title' => 'Double quote &quot;'],
            $title,
            '/a',
        ];
        $this->assertHtml($expected, $result);

        //Code on text
        $result = $this->Html->link('<u>Code</u> and text', '#');
        $expected = [
            'a' => ['href' => '#', 'title' => 'Code and text'],
            'u' => true,
            'Code',
            '/u',
            ' and text',
            '/a',
        ];
        $this->assertHtml($expected, $result);

        //Code on custom title
        $result = $this->Html->link(
            $title,
            '#',
            ['title' => '<u>Code</u> and text']
        );
        $expected = [
            'a' => ['href' => '#', 'title' => 'Code and text'],
            $title,
            '/a',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `meta()` method
     * @return void
     * @test
     */
    public function testMeta()
    {
        //By default, `block` is `true`
        $result = $this->Html->meta('viewport', 'width=device-width');
        $this->assertNull($result);

        $result = $this->Html->meta(
            'viewport',
            'width=device-width',
            ['block' => true]
        );
        $this->assertNull($result);

        $result = $this->Html->meta(
            'viewport',
            'width=device-width',
            ['block' => false]
        );
        $expected = [
            'meta' => ['name' => 'viewport', 'content' => 'width=device-width']
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `nestedList`, `ol()` and `ul()` methods
     * @return void
     * @test
     */
    public function testNestedListAndOlAndUl()
    {
        $list = ['first', 'second'];

        $result = $this->Html->ul($list, [], ['icon' => 'home']);
        $expected = [
            'ul' => ['class' => 'fa-ul'],
            ['li' => true],
            ['i' => ['class' => 'fa fa-home fa-li']],
            ' ',
            '/i',
            ' ',
            'first',
            '/li',
            ['li' => true],
            ['i' => ['class' => 'fa fa-home fa-li']],
            ' ',
            '/i',
            ' ',
            'second',
            '/li',
            '/ul',
        ];
        $this->assertHtml($expected, $result);

        //It's the same
        $result = $this->Html->ul($list, ['icon' => 'home']);
        $expected = $this->Html->ul($list, [], ['icon' => 'home']);
        $this->assertEquals($expected, $result);

        $result = $this->Html->ul(
            $list,
            ['class' => 'list-class'],
            ['class' => 'item-class', 'icon' => 'home']
        );
        $expected = [
            'ul' => ['class' => 'list-class fa-ul'],
            ['li' => ['class' => 'item-class']],
            ['i' => ['class' => 'fa fa-home fa-li']],
            ' ',
            '/i',
            ' ',
            'first',
            '/li',
            ['li' => ['class' => 'item-class']],
            ['i' => ['class' => 'fa fa-home fa-li']],
            ' ',
            '/i',
            ' ',
            'second',
            '/li',
            '/ul',
        ];
        $this->assertHtml($expected, $result);

        //By default, `nestedList()` created `<ul>` list
        $result = $this->Html->ul($list);
        $expected = $this->Html->nestedList($list);
        $this->assertEquals($expected, $result);

        $result = $this->Html->ul($list);
        $expected = $this->Html->nestedList($list, ['tag' => 'ul']);
        $this->assertEquals($expected, $result);

        $result = $this->Html->ul($list, ['class' => 'my-class']);
        $expected = $this->Html->nestedList(
            $list,
            ['class' => 'my-class', 'tag' => 'ul']
        );
        $this->assertEquals($expected, $result);

        $result = $this->Html->ol($list, ['class' => 'my-class']);
        $expected = $this->Html->nestedList(
            $list,
            ['class' => 'my-class', 'tag' => 'ol']
        );
        $this->assertEquals($expected, $result);
    }

    /**
     * Test for `para()` method
     * @return void
     * @test
     */
    public function testPara()
    {
        $expected = ['p' => true, '/p'];

        $result = $this->Html->para();
        $this->assertHtml($expected, $result);

        $result = $this->Html->para(null);
        $this->assertHtml($expected, $result);

        $result = $this->Html->para(null, null);
        $this->assertHtml($expected, $result);

        $result = $this->Html->para(null, '');
        $this->assertHtml($expected, $result);

        $expected = ['p' => ['class' => 'my-class']];

        $result = $this->Html->para('my-class');
        $this->assertHtml($expected, $result);

        $result = $this->Html->para('my-class', null);
        $this->assertHtml($expected, $result);

        $result = $this->Html->para(null, ' ');
        $expected = ['p' => true, ' ', '/p'];
        $this->assertHtml($expected, $result);

        $result = $this->Html->para(
            null,
            'my text',
            ['tooltip' => 'my tooltip']
        );
        $expected = [
            'p' => ['data-toggle' => 'tooltip', 'title' => 'my tooltip'],
            'my text',
            '/p'
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->para(
            'my-class',
            'my text',
            ['id' => 'my-id', 'icon' => 'home']
        );
        $expected = [
            'p' => ['class' => 'my-class', 'id' => 'my-id'],
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            'my text',
            '/p'
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `script()` and `js()` methods
     * @return void
     * @test
     */
    public function testScript()
    {
        //By default, `block` is `true`
        $result = $this->Html->script('my-file');
        $this->assertNull($result);

        $result = $this->Html->script('my-file2', ['block' => true]);
        $this->assertNull($result);

        $result = $this->Html->script('my-file3', ['block' => false]);
        $expected = [
            'script' => ['src' => '/js/my-file3.js']
        ];
        $this->assertHtml($expected, $result);

        //By default, `block` is `true`
        $result = $this->Html->js('my-file4');
        $this->assertNull($result);

        $result = $this->Html->js('my-file5', ['block' => true]);
        $this->assertNull($result);

        $result = $this->Html->js('my-file6', ['block' => false]);
        $expected = [
            'script' => ['src' => '/js/my-file6.js']
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `scriptBlock()` method
     * @return void
     * @test
     */
    public function testScriptBlock()
    {
        $code = 'window.foo = 2;';

        //By default, `block` is `true`
        $result = $this->Html->scriptBlock($code, ['safe' => false]);
        $this->assertNull($result);

        $result = $this->Html->scriptBlock(
            $code,
            ['block' => true, 'safe' => false]
        );
        $this->assertNull($result);

        $result = $this->Html->scriptBlock(
            $code,
            ['block' => false, 'safe' => false]
        );
        $expected = [
            '<script',
            $code,
            '/script',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `scriptStart()` and `scriptEnd()` methods
     * @return void
     * @test
     */
    public function testScriptStartAndScriptEnd()
    {
        //By default, `block` is `true`
        $result = $this->Html->scriptStart(['safe' => false]);
        $this->assertNull($result);

        echo 'this is some javascript';

        $result = $this->Html->scriptEnd();
        $this->assertNull($result);

        $result = $this->Html->scriptStart(['block' => true, 'safe' => false]);
        $this->assertNull($result);

        echo 'this is some javascript';

        $result = $this->Html->scriptEnd();
        $this->assertNull($result);

        $result = $this->Html->scriptStart(['block' => false, 'safe' => false]);
        $this->assertNull($result);

        echo 'this is some javascript';

        $result = $this->Html->scriptEnd();
        $expected = ['<script', 'this is some javascript', '/script'];
        $this->assertHtml($expected, $result);
    }

    /**
     * Tests for `shareaholic()` method
     * @return void
     * @test
     */
    public function testShareaholic()
    {
        $result = $this->Html->shareaholic('my-app-id');
        $expected = [
            'div' => [
                'data-app' => 'share_buttons',
                'data-app-id' => 'my-app-id',
                'class' => 'shareaholic-canvas',
            ],
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test for `tag()` method
     * @return void
     * @test
     */
    public function testTag()
    {
        $text = 'My text';
        $class = 'my-class';

        $expected = ['h3' => true, '/h3'];

        $result = $this->Html->tag('h3');
        $this->assertHtml($expected, $result);

        $result = $this->Html->tag('h3', null);
        $this->assertHtml($expected, $result);

        $result = $this->Html->tag('h3', '');
        $this->assertHtml($expected, $result);

        $result = $this->Html->tag('h3', $text, ['class' => $class]);
        $expected = [
            'h3' => ['class' => $class],
            $text,
            '/h3',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->tag('h3', $text, ['tooltip' => 'my tooltip']);
        $expected = [
            'h3' => ['data-toggle' => 'tooltip', 'title' => 'my tooltip'],
            $text,
            '/h3',
        ];
        $this->assertHtml($expected, $result);

        // `tooltip` value rewrites `title` value
        $result = $this->Html->tag(
            'h3',
            $text,
            ['title' => 'my custom title', 'tooltip' => 'my tooltip']
        );
        $expected = [
            'h3' => ['data-toggle' => 'tooltip', 'title' => 'my tooltip'],
            $text,
            '/h3',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->tag(
            'h3',
            $text,
            ['class' => '$class', 'icon' => 'home']
        );
        $expected = [
            'h3' => ['class' => '$class'],
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            ' ',
            $text,
            '/h3',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->tag(
            'h3',
            $text,
            ['class' => '$class', 'icon' => 'home', 'icon-align' => 'right']
        );
        $expected = [
            'h3' => ['class' => '$class'],
            $text,
            ' ',
            'i' => ['class' => 'fa fa-home'],
            ' ',
            '/i',
            '/h3',
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Tests for `viewport()` method
     * @return void
     * @test
     */
    public function testViewport()
    {
        //By default, `block` is `true`
        $result = $this->Html->viewport();
        $this->assertNull($result);

        $result = $this->Html->viewport(['block' => true]);
        $this->assertNull($result);

        $result = $this->Html->viewport(['block' => false]);
        $expected = [
            'meta' => [
                'name' => 'viewport',
                'content' => 'initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width',
            ],
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->viewport([
            'block' => false,
            'custom-option' => 'custom-value',
        ]);
        $expected = [
            'meta' => [
                'custom-option' => 'custom-value',
                'name' => 'viewport',
                'content' => 'initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width',
            ],
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Tests for `youtube()` method
     * @return void
     * @test
     */
    public function testYoutube()
    {
        $id = 'my-id';
        $url = sprintf('https://www.youtube.com/embed/%s', $id);

        $result = $this->Html->youtube($id);
        $expected = [
            'div' => ['class' => 'embed-responsive embed-responsive-16by9'],
            'iframe' => [
                'allowfullscreen' => 'allowfullscreen',
                'height' => '480',
                'width' => '640',
                'class' => 'embed-responsive-item',
                'src' => $url,
            ],
            '/iframe',
            '/div',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->youtube($id, ['ratio' => '4by3']);
        $expected = [
            'div' => ['class' => 'embed-responsive embed-responsive-4by3'],
            'iframe' => [
                'allowfullscreen' => 'allowfullscreen',
                'height' => '480',
                'width' => '640',
                'class' => 'embed-responsive-item',
                'src' => $url,
            ],
            '/iframe',
            '/div',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->youtube($id, ['ratio' => false]);
        $expected = [
            'iframe' => [
                'allowfullscreen' => 'allowfullscreen',
                'height' => '480',
                'width' => '640',
                'src' => $url,
            ],
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->youtube($id, ['height' => 100, 'width' => 200]);
        $expected = [
            'div' => ['class' => 'embed-responsive embed-responsive-16by9'],
            'iframe' => [
                'allowfullscreen' => 'allowfullscreen',
                'height' => '100',
                'width' => '200',
                'class' => 'embed-responsive-item',
                'src' => $url,
            ],
            '/iframe',
            '/div',
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Html->youtube($id, ['class' => 'my-class']);
        $expected = [
            'div' => ['class' => 'embed-responsive embed-responsive-16by9'],
            'iframe' => [
                'allowfullscreen' => 'allowfullscreen',
                'height' => '480',
                'width' => '640',
                'class' => 'my-class embed-responsive-item',
                'src' => $url,
            ],
            '/iframe',
            '/div',
        ];
        $this->assertHtml($expected, $result);
    }
}
