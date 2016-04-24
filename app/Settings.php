<?php

namespace App;

use DB;

class Settings
{

    static $settings = [];

    /**
     * Allow settings to be accessed as properties
     *
     * @param  string $name The name of the setting
     * @return mixed        The value of the setting
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Allow settings to be set as properties
     *
     * @param string $name The name of the setting
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Get the value of a setting from the DB
     *
     * @param  string $name The setting to retrieve
     * @return mixed           The value of the setting
     */
    public static function get($name)
    {
        // Check if the setting is cached in our static array
        if (isset(self::$settings[$name])) {
            return self::$settings[$name];
        }

        $setting = DB::table('settings')
            ->select('value', 'serialized')
            ->where('name', $name)
            ->first();

        if (!$setting) {
            self::$settings[$name] = null;
        } elseif ($setting->serialized) {
            self::$settings[$name] = unserialize($setting->value);
        } else {
            self::$settings[$name] = $setting->value;
        }

        return self::$settings[$name];
    }

    /**
     * Set a setting and store it in the DB
     *
     * @param string $name  The setting to set
     * @param mixed  $value The value to set the setting to, arrays/objects are automatically serialized
     */
    public static function set($name, $value)
    {
        $serialized = false;

        // Cache the setting in our static array
        self::$settings[$name] = $value;

        if (is_array($value) || is_object($value)) {
            $value      = serialize($value);
            $serialized = true;
        }

        if (DB::table('settings')->where('name', $name)->count() == 0) {
            DB::table('settings')->insert(
                [
                    'name'       => $name,
                    'value'      => $value,
                    'serialized' => $serialized,
                ]
            );
        } else {
            DB::table('settings')->where('name', $name)->update(
                [
                    'value'      => $value,
                    'serialized' => $serialized,
                ]
            );
        }
    }

    /**
     * Delete a setting from the DB
     *
     * @param  string $name The name of the setting to delete
     */
    public static function delete($name)
    {
        unset(self::$settings[$name]);

        DB::table('settings')->where('name', $name)->delete();
    }
}