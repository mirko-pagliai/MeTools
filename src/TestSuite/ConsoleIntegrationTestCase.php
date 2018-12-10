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
 * @since       2.15.0
 */
namespace MeTools\TestSuite;

use Cake\Console\Command as CakeCommand;
use Cake\Console\Shell as CakeShell;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use MeTools\Console\Command;
use MeTools\Console\Shell;
use MeTools\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Abstract class for console helpers
 */
abstract class ConsoleIntegrationTestCase extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Shell instance
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $Shell;

    /**
     * If `true`, a mock instance of the shell will be created
     * @var bool
     */
    protected $autoInitializeClass = false;

    /**
     * Called before every test method
     * @return void
     * @uses $Shell
     * @uses $autoInitializeClass
     */
    public function setUp()
    {
        parent::setUp();

        $this->loadPlugins(['MeTools']);

        $className = $this->getOriginClassName($this);
        if (!$this->Shell && $this->autoInitializeClass) {
            $this->Shell = $this->getMockForShell($className);
        }

        $parts = explode('\\', $className);
        if (next($parts) === 'Command') {
            $this->useCommandRunner();
        }
    }

    /**
     * Gets all shell methods.
     *
     * It excludes the `main` method.
     * @param array $exclude Other methods you want to exclude
     * @return array
     * @uses $Shell
     */
    protected function getShellMethods(array $exclude = [])
    {
        !empty($this->Shell) ?: $this->fail('The property `$this->Shell` has not been set');

        $class = $this->Shell instanceof MockObject ? get_parent_class($this->Shell) : $this->Shell;
        $parentClass = get_parent_class($class);
        $methods = get_child_methods($class);

        if (!in_array($parentClass, [CakeCommand::class, CakeShell::class, Command::class, Shell::class])) {
            $methods = array_merge($methods, get_child_methods($parentClass));
        }

        $methods = array_diff($methods, array_merge(['main'], $exclude));
        sort($methods);

        return $methods;
    }

    /**
     * Asserts shell exited with the error code
     * @param string $message Failure message to be appended to the generated
     *  message
     * @return void
     */
    public function assertExitWithError($message = '')
    {
        $this->assertExitCode(Shell::CODE_ERROR, $message);
    }

    /**
     * Asserts shell exited with the success code
     * @param string $message Failure message to be appended to the generated
     *  message
     * @return void
     */
    public function assertExitWithSuccess($message = '')
    {
        $this->assertExitCode(Shell::CODE_SUCCESS, $message);
    }

    /**
     * Asserts that `stdout` is not empty
     * @param string $message Failure message to be appended to the generated
     *  message
     * @return void
     * @since 2.17.6
     */
    public function assertOutputNotEmpty($message = '')
    {
        $this->assertNotEmpty($this->_out->messages(), $message);
    }
}
