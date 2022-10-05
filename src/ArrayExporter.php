<?php

namespace App;

class ArrayExporter
{
    /**
     * Exports array of services into string
     */
    public static function export(array $array): string
    {
        $result = "<?php\n\nreturn [\n";
        foreach ($array as $key => $value) {
            $result .= '    \''.$key.'\' => '.$value.",\n";
        }
        return $result.'];';
    }
}
