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

use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use MeTools\Command\Install\CreateDirectoriesCommand;
use MeTools\TestSuite\ConsoleIntegrationTestTrait;
use MeTools\TestSuite\TestCase;

/**
 * CreateDirectoriesCommandTest class
 */
class CreateDirectoriesCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Tests for `execute()` method
     * @test
     */
    public function testExecute()
    {
        $io = new ConsoleIo;
        $Command = $this->getMockBuilder(CreateDirectoriesCommand::class)
            ->setMethods(['createDir'])
            ->getMock();

        $count = 0;
        foreach (Configure::read('WRITABLE_DIRS') as $path) {
            $Command->expects($this->at($count++))
                ->method('createDir')
                ->with($io, $path);
        }

        $Command->expects($this->exactly(count(Configure::read('WRITABLE_DIRS'))))
            ->method('createDir');

        $this->assertNull($Command->run([], $io));
    }
}
