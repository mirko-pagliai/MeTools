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
namespace MeTools\Test\TestCase\Command;

use MeTools\TestSuite\ConsoleIntegrationTestCase;

/**
 * CreateDirectoriesCommandTest class
 */
class CreateDirectoriesCommandTest extends ConsoleIntegrationTestCase
{
    /**
     * Tests for `execute()` method
     * @test
     */
    public function testExecute()
    {
        $pathsAlreadyExist = [TMP, TMP . 'cache', WWW_ROOT . 'vendor'];
        foreach ($pathsAlreadyExist as $path) {
            safe_mkdir($path, 0777, true);
        }

        $pathsToBeCreated = array_diff($this->Shell->paths, $pathsAlreadyExist);
        array_walk($pathsToBeCreated, 'safe_rmdir');

        $this->exec('me_tools.create_directories -v');
        $this->assertExitWithSuccess();

        foreach ($pathsAlreadyExist as $path) {
            $this->assertOutputContains('File or directory `' . rtr($path) . '` already exists');
        }

        foreach ($pathsToBeCreated as $path) {
            $this->assertOutputContains('Created `' . rtr($path) . '` directory');
            $this->assertOutputContains('Setted permissions on `' . rtr($path) . '`');
        }

        $this->assertErrorEmpty();
    }
}
