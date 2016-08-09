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
 * @author		Mirko Pagliai <mirko.pagliai@gmail.com>
 * @copyright	Copyright (c) 2016, Mirko Pagliai for Nova Atlantis Ltd
 * @license		http://www.gnu.org/licenses/agpl.txt AGPL License
 * @link		http://git.novatlantis.it Nova Atlantis Ltd
 */

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

if(!function_exists('af')) {
	/**
	 * Cleans an array, removing values equal to `FALSE` (`array_filter()`)
	 * @param array $array Array
	 * @return array Array
	 */
	function af($array) {
		return array_filter($array);
	}
}

if(!function_exists('am')) {
	/**
	* Merge a group of arrays.
	* Accepts variable arguments. Each argument will be converted into an 
     *  array and then merged.
	* @return array All array parameters merged into one
	*/
	function am() {
		foreach(func_get_args() as $arg) {
			$array = array_merge(empty($array) ? [] : $array, (array) $arg);
        }
        
		return $array;
	}
}

if(!function_exists('clear_dir')) {
	/**
	 * Cleans a directory
	 * @param string $directory Directory path
	 * @return boolean
	 */
	function clear_dir($directory) {
		if(!folder_is_writeable($directory)) {
			return FALSE;
        }
		
		$success = TRUE;
		
		//Gets files
		$files = (new Folder($directory))->read(FALSE, ['empty'])[1];
		
		//Deletes each file
		foreach($files as $file) {
			if(!(new File($directory.DS.$file))->delete()) {
				$success = FALSE;
            }
		}
		
		return $success;
	}
}

if(!function_exists('fk')) {
	/**
	 * Returns the first key of an array
	 * @param array $array Array
	 * @return string First key
	 */
	function fk($array) {
		if(empty($array) || !is_array($array)) {
			return NULL;
        }
		
		return current(array_keys($array));
	}
}

if(!function_exists('folder_is_writeable')) {
	/**
	 * Checks if a directory and its subdirectories are readable and writable
	 * @param string $dir Directory path
	 * @return boolean
	 */
	function folder_is_writeable($dir) {
		if(!is_readable($dir) || !is_writeable($dir)) {
			return FALSE;
        }

        foreach((new Folder())->tree($dir, FALSE, 'dir') as $subdir) {
            if(!is_readable($subdir) || !is_writeable($subdir)) {
                return FALSE;
            }
        }

        return TRUE;
	}
}

if(!function_exists('fv')) {
	/**
	 * Returns the first value of an array
	 * @param array $array Array
	 * @return mixed First value
	 */
	function fv($array) {
		if(empty($array) || !is_array($array)) {
			return NULL;
        }
		
		return array_values($array)[0];
	}
}

if(!function_exists('get_client_ip')) {
	/**
	 * Gets the client IP
	 * @return string|bool Client IP or `FALSE`
	 * @see http://stackoverflow.com/a/15699240/1480263
	 */
	function get_client_ip() {
		if(filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP')) {
            $ip = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP');
        }
		elseif(filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR')) {
			$ip = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR');
        }
		elseif(filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED')) {
			$ip = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED');
        }
		elseif(filter_input(INPUT_SERVER, 'HTTP_FORWARDED_FOR')) {
			$ip = filter_input(INPUT_SERVER, 'HTTP_FORWARDED_FOR');
        }
		elseif(filter_input(INPUT_SERVER, 'HTTP_FORWARDED')) {
			$ip = filter_input(INPUT_SERVER, 'HTTP_FORWARDED');
        }
		elseif(filter_input(INPUT_SERVER, 'REMOTE_ADDR')) {
			$ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        }
		
        if(empty($ip)) {
            return FALSE;
        }
        
        if($ip === '::1') {
            return '127.0.0.1';
        }
        
        return $ip;
	}
}

if(!function_exists('is_json')) {
	/**
	 * Checks if a string is JSON
	 * @param string $string
	 * @return bool
	 */
	function is_json($string) {
		@json_decode($string);
		return json_last_error() === JSON_ERROR_NONE;
	}
}

if(!function_exists('is_localhost')) {
	/**
	 * Checks if the host is the localhost
	 * @return bool
	 */
    function is_localhost() {		
		return get_client_ip() === '127.0.0.1';
	}
}

if(!function_exists('is_positive')) {
    /**
     * Checks if a string is a positive number
     * @param string $string
     * @return bool
     */
    function is_positive($string) {
        return is_numeric($string) && $string > 0 && $string == round($string);
    }
}

if(!function_exists('is_remote')) {
    /**
     * Alias for `is_url()` function
     */
	function is_remote() {
		return call_user_func_array('is_url', func_get_args());
	}
}

if(!function_exists('is_url')) {
	/**
	 * Checks whether a url is invalid
	 * @param string $url Url
	 * @return bool
	 */
	function is_url($url) {
		return (bool) preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url);
	}
}

if(!function_exists('optionDefaults')) {
	/**
	 * Adds a default values to html options.
     * 
     * Example:
     * <code>
     * $options = optionDefaults([
     *  'class' => 'this-is-my-class',
     *  'data-balue => 'example-value',
     * ], $options);
     * </code>
     * 
     * To provide backward compatibility, this function can accept three 
     * arguments (value name, value, options).
     * @param array $values Options values
	 * @param array $options Options
	 * @return array Options
     */
	function optionDefaults($values, $options) {
        if(func_num_args() === 3) {
            $values = [func_get_arg(0) => func_get_arg(1)];
            $options = func_get_arg(2);
        }

        foreach($values as $key => $value) {
            if(empty($options[$key])) {
                $options[$key] = $value;
            }
        }

        return $options;
	}
}

if(!function_exists('optionValues')) {
	/**
	 * Adds values to html options.
     * 
     * Example:
     * <code>
     * $options = optionValues([
     *  'class' => 'this-is-my-class',
     *  'data-balue => 'example-value',
     * ], $options);
     * </code>
     * 
     * To provide backward compatibility, this function can accept three 
     * arguments (value name, value, options).
     * @param array $values Options values
	 * @param array $options Options
	 * @return array Options
	 */
	function optionValues($values, $options) {
        if(func_num_args() === 3) {
            $values = [func_get_arg(0) => func_get_arg(1)];
            $options = func_get_arg(2);
        }

        foreach($values as $key => $value) {
            if(empty($options[$key])) {
                $options[$key] = $value;
            }
            else {
                //Turns into array, adds value and turns again into string
                $options[$key] = preg_split('/\s/', $options[$key]);
                $options[$key] = am($options[$key], (array) $value);
                $options[$key] = implode(' ', array_unique($options[$key]));
            }
        }

        return $options;
	}
}

if(!function_exists('rtr')) {
	/**
	 * Returns the relative path (to the APP root) of an absolute path
	 * @param string $path Absolute path
	 * @return string Relativa path
	 */
	function rtr($path) {
		return preg_replace(sprintf('/^%s/', preg_quote(ROOT.DS, DS)), NULL, $path);
	}
}

if(!function_exists('which')) {
	/**
	 * Executes the `which` command.
	 * 
	 * It shows the full path of (shell) commands.
	 * @param string $command Command
	 * @return string Full path of command
	 */
	function which($command) {
		return exec(sprintf('which %s', $command));
	}
}