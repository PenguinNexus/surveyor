<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ParamOutTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ParamOutTagValueNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}

// class Example
// {
//     /**
//      * Parse configuration data
//      *
//      * @param string $input The input string to parse
//      * @param-out array<string, mixed> $config Parsed configuration array
//      * @param-out int $errorCount Number of parsing errors encountered
//      *
//      * @return bool True if parsing was successful
//      */
//     public function parseConfig(string $input, array &$config, int &$errorCount): bool
//     {
//         $config = [];
//         $errorCount = 0;

//         // Parse the input and populate $config and $errorCount by reference
//         $lines = explode("\n", $input);
//         foreach ($lines as $line) {
//             if (empty(trim($line))) continue;

//             if (strpos($line, '=') !== false) {
//                 [$key, $value] = explode('=', $line, 2);
//                 $config[trim($key)] = trim($value);
//             } else {
//                 $errorCount++;
//             }
//         }

//         return $errorCount === 0;
//     }
// }

// // Usage
// $parser = new Example();
// $input = "name=John\nage=30\ninvalid_line\nemail=john@example.com";

// $config = null;      // Will be populated by the function
// $errorCount = null;  // Will be populated by the function

// $success = $parser->parseConfig($input, $config, $errorCount);

// After the call:
// $config is now array<string, mixed> ['name' => 'John', 'age' => '30', 'email' => 'john@example.com']
// $errorCount is now int (1)
