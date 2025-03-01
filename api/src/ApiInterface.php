<?php
// filepath: c:\Users\cshan\OneDrive\Desktop\Projects\com_fixassets\api\src\ApiInterface.php
namespace RipGraphics\Component\Fixassets\Api;

/**
 * Interface for the API class.
 *
 * @since   1.0.0
 */
interface ApiInterface
{
    /**
     * A simple API method.
     *
     * @param   string  $input  Some input parameter.
     *
     * @return  string
     *
     * @since   1.0.0
     */
    public function apiMethod(string $input): string;
}