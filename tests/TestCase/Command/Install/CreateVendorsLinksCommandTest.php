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
namespace MeTools\Test\TestCase\Command\Install;

use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use MeTools\Command\Install\CreateVendorsLinksCommand;
use MeTools\TestSuite\ConsoleIntegrationTestTrait;
use MeTools\TestSuite\TestCase;

/**
 * CreateVendorsLinksCommandTest class
 */
class CreateVendorsLinksCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Tests for `execute()` method
     * @test
     */
    public function testExecute()
    {
        $io = new ConsoleIo;
        $Command = $this->getMockBuilder(CreateVendorsLinksCommand::class)
            ->setMethods(['createLink'])
            ->getMock();

        $count = 0;
        foreach (Configure::read('VENDOR_LINKS') as $origin => $target) {
            $Command->expects($this->at($count++))
                ->method('createLink')
                ->with($io, ROOT . 'vendor' . DS . $origin, WWW_ROOT . 'vendor' . DS . $target);
        }

        $Command->expects($this->exactly(count(Configure::read('VENDOR_LINKS'))))
            ->method('createLink');

        $result = $Command->execute(new Arguments([], [], []), $io);
        $this->assertNull($result);
    }
}
