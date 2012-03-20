<?php defined('SYSPATH') or die('No direct script access.');

class File extends Kohana_File {
    
    public static function find($path)
    {
        return is_file($path);
    }

    public static function filesize($bytes, $format = '', $force = '')
    {
        $bytes = (float)$bytes;
        $force = strtoupper($force);
        $defaultFormat = '%01d %s';

        if (strlen($format) == 0)
        {
            $format = $defaultFormat;
        }

        $bytes = max(0, (int) $bytes);
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        $power = array_search($force, $units);
        
        if ($power === FALSE)
        {
            $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        }

        return sprintf($format, $bytes / pow(1024, $power), $units[$power]);
    }

    public static function normalize_extension($files)
    {
        $patterns = array('jpeg');

        $replacements = array('jpg');

        foreach ($files as &$file)
        {
            if ( ! is_array($file['name']))
            {
                $file['name'] = str_replace($patterns, $replacements, $file['name']);
                $file['name'] = UTF8::strtolower($file['name']);
            }
            else
            {
                foreach ($file['name'] as &$item)
                {
                    $item = str_replace($patterns, $replacements, $item);
                    $item = UTF8::strtolower($item);
                }
            }
        }

        return $files;
    }

    public static function parse_html5_file($files, $key)
    {
        $array = Arr::get($files, $key);

        if ($array)
        {
            return array(
                'name' => Arr::path($array, 'name.0'),
                'type' => Arr::path($array, 'type.0'),
                'tmp_name' => Arr::path($array, 'tmp_name.0'),
                'error' => Arr::path($array, 'error.0'),
                'size' => Arr::path($array, 'size.0')
            );
        }

        return null;
    }

    public static function get_base64_file($file_path)
    {
        $contents = file_get_contents($file_path);
        $base64 = base64_encode($contents);

        return "data:".File::mime_by_ext(pathinfo($file_path, PATHINFO_EXTENSION)).";base64,$base64";
    }

    public static function get_files_tree($path, $prefix = '')
    {
        $files = array();

        $path = realpath($path);

        if (is_dir($path))
        {
            $dir_files = scandir($path);
            unset($dir_files[0], $dir_files[1]);

            foreach ($dir_files as $file)
            {
                $this_path = realpath($path.'/'.$file);
                $files[$this_path] = array('name' => $prefix.$file, 'is_dir' => is_dir($this_path), 'path' => realpath($this_path));
                $files = Arr::merge($files, self::get_files_tree($this_path, $prefix.'&nbsp;&nbsp;&nbsp;'));
            }
        }

        return $files;
    }

    public static function remove_base_path($path, $base)
    {
        return str_replace($base, '', $path);
    }
}