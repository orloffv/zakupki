<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'ru_RU.UTF-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru-ru');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

$ip = explode('.', Arr::get($_SERVER, 'REMOTE_ADDR'));
Kohana::$environment = (($ip[0] == 127 OR $ip[0] == 192) AND ($ip[1] == 0 OR $ip[1]))
    ? Kohana::DEVELOPMENT
    : Kohana::PRODUCTION;
unset($ip);

if (Kohana::$is_cli)
{
    if (Cli::options('env'))
    {
        $cli_env = Cli::options('env');
        Kohana::$environment = Arr::get($cli_env, 'env') == 'dev' ? Kohana::DEVELOPMENT : Kohana::PRODUCTION;
    }
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
    'index_file' => FALSE,
    'profile'    => Kohana::$environment !== Kohana::PRODUCTION,
    'caching'    => Kohana::$environment === Kohana::PRODUCTION,
    'errors'     => Kohana::$environment !== Kohana::PRODUCTION,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */

$production_modules = array(

);

$development_modules = array(
    //'codebench'    => MODPATH.'codebench',
    //'unittest'     => MODPATH.'unittest',
);

$default_modules = array(
    'cache'        => MODPATH.'cache',
    'database'     => MODPATH.'database',
    'jelly'        => MODPATH.'jelly',
    'pagination'   => MODPATH.'pagination',
    'message'      => MODPATH.'message',
    'kohana-morphy'=> MODPATH.'kohana-morphy',
);

$modules = (Kohana::$environment === Kohana::PRODUCTION) ?
    Arr::merge($default_modules, $production_modules) :
    Arr::merge($default_modules, $development_modules);

Kohana::modules($modules);

if (Kohana::$environment === Kohana::PRODUCTION)
{
	is_file(APPPATH.'production'.EXT) AND require APPPATH.'production'.EXT;
}
elseif (Kohana::$environment === Kohana::DEVELOPMENT)
{
    is_file(APPPATH.'development'.EXT) AND require APPPATH.'development'.EXT;
}

Cookie::$salt = 'hyper-security';

if (Kohana::$is_cli)
{
    Route::set('cli', '(<controller>(/<action>(/<id>)))')
        ->defaults(array(
        'directory' => 'cli',
        'controller' => 'cron',
        'action'     => 'ls',
    ));
}
else
{
    if ( ! Route::cache(FALSE))
    {
        // > Backend
        Route::get_backend_route();
        // < Backend

        // > Frontend
        Route::get_frontend_route();
        // < Frontend

        Route::cache(TRUE, NULL, Cache::$lifetime['route']);
    }
}
