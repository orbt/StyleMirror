<?php
/*
 * @
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

spl_autoload_register(function ($class) {
    @list($empty, $name) = explode('Orbt\\ResourceManager\\', ltrim($class, '\\'), 2);
    if (!strlen($empty) && file_exists($file = __DIR__.'/../'.strtr($name, '\\', '/').'.php')) {
        require_once $file;
    }
});