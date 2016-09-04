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
 * @see         http://api.cakephp.org/3.3/class-Cake.Console.Shell.html Shell
 */
namespace MeTools\Console;

use Cake\Console\Shell as CakeShell;

/**
 * Base class for command-line utilities for automating programmer chores.
 *
 * Rewrites {@link http://api.cakephp.org/3.3/class-Cake.Console.Shell.html Shell}.
 */
class Shell extends CakeShell
{
    /**
     * Constructs this Shell instance
     * @param \Cake\Console\ConsoleIo|null $io An io instance.
     */
    public function __construct(\Cake\Console\ConsoleIo $io = null)
    {
        parent::__construct($io);

        //Adds bold style
        $this->_io->styles('bold', ['bold' => true]);
    }

    /**
     * Rewrites the header for the shell
     * @return void
     */
    protected function _welcome()
    {
    }

    /**
     * Convenience method that wraps message between <bold /> tag
     * @param string $message Message
     * @return string
     */
    protected function bold($message)
    {
        return sprintf('<bold>%s</bold>', $message);
    }

    /**
     * Creates a file at given path
     * @param string $path Where to put the file
     * @param string $contents Content to put in the file
     * @return bool
     * @uses Cake\Console\Shell::createFile()
     */
    public function createFile($path, $contents)
    {
        //Checks if the file already exist
        if (file_exists($path)) {
            $this->verbose(__d(
                'me_tools',
                'File or directory {0} already exists',
                $this->bold(rtr($path))
            ));

            return false;
        }

        //Checks if the file has been created
        if (!parent::createFile($path, $contents)) {
            $this->err(__d(
                'me_tools',
                'The file {0} has not been created',
                $this->bold(rtr($path))
            ));

            return false;
        }

        return true;
    }

    /**
     * Creates a symbolic link
     * @param string $origin Origin file or directory
     * @param string $target Target link
     * @return bool
     */
    public function createLink($origin, $target)
    {
        //Checks if the origin file/directory is readable
        if (!is_readable($origin)) {
            $this->err(__d(
                'me_tools',
                'File or directory {0} not readable',
                $this->bold(rtr($origin))
            ));

            return false;
        }

        //Checks if the link already exists
        if (file_exists($target)) {
            $this->verbose(__d(
                'me_tools',
                'Symbolic link {0} already exists',
                $this->bold(rtr($target))
            ));

            return false;
        }

        //Checks if the target directory is writeable
        if (!is_writable(dirname($target))) {
            $this->err(__d(
                'me_tools',
                'File or directory {0} not writeable',
                $this->bold(rtr(dirname($target)))
            ));

            return false;
        }

        //Creates the symbolic link
        if (!symlink($origin, $target)) {
            $this->err(__d(
                'me_tools',
                'Failed to create a symbolic link to {0}',
                $this->bold(rtr($target))
            ));

            return false;
        }

        $this->verbose(__d(
            'me_tools',
            'Created symbolic link to {0}',
            $this->bold(rtr($target))
        ));

        return true;
    }

    /**
     * Convenience method for out() that wraps message between <comment /> tag
     * @param string|array|null $message A string or an array of strings to
     *  output
     * @param int $newlines Number of newlines to append
     * @param int $level The message's output level, see above
     * @return int|bool Returns the number of bytes returned from writing to
     *  stdout
     */
    public function comment(
        $message = null,
        $newlines = 1,
        $level = Shell::NORMAL
    ) {
        return parent::out(
            sprintf('<comment>%s</comment>', $message),
            $newlines,
            $level
        );
    }

    /**
     * Convenience method for out() that wraps message between <question /> tag
     * @param string|array|null $message A string or an array of strings to
     *  output
     * @param int $newlines Number of newlines to append
     * @param int $level The message's output level, see above
     * @return int|bool Returns the number of bytes returned from writing to
     *  stdout
     */
    public function question(
        $message = null,
        $newlines = 1,
        $level = Shell::NORMAL
    ) {
        return parent::out(
            sprintf('<question>%s</question>', $message),
            $newlines,
            $level
        );
    }

    /**
     * Convenience method for err() that wraps message between <warning /> tag
     * @param string|array|null $message A string or an array of strings to
     *  output
     * @param int $newlines Number of newlines to append
     * @return int|bool Returns the number of bytes returned from writing to
     *  stdout
     */
    public function warning($message = null, $newlines = 1)
    {
        return parent::warn($message, $newlines);
    }
}
