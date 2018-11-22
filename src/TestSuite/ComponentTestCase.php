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
 * @since       2.17.5
 */
namespace MeTools\TestSuite;

use MeTools\TestSuite\TestCase;
use MeTools\TestSuite\Traits\MockTrait;

/**
 * Abstract class for test components
 */
abstract class ComponentTestCase extends TestCase
{
    use MockTrait;

    /**
     * Component instance
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $Component;

    /**
     * Called before every test method
     * @return void
     * @uses $Component
     */
    public function setUp()
    {
        parent::setUp();

        //Tries to retrieve the component
        if (!$this->Component) {
            $this->Component = $this->getMockForComponent($this->getOriginClassName($this), null);
        }
    }
}
