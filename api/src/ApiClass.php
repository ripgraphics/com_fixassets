<?php
// filepath: c:\Users\cshan\OneDrive\Desktop\Projects\com_fixassets\api\src\ApiClass.php
namespace RipGraphics\Component\Fixassets\Api;

use Joomla\CMS\Log\Log;

/**
 * Class ApiClass
 *
 * @since   1.0.0
 */
class ApiClass implements ApiInterface
{
    /**
     * Implementation of the apiMethod.
     *
     * @param   string  $input  Some input parameter.
     *
     * @return  string
     *
     * @since   1.0.0
     */
    public function apiMethod(string $input): string
    {
          Log::add('ApiClass::apiMethod called with input: ' . $input, Log::INFO, 'com_fixassets');
        return 'API Response: ' . $input;
    }
}