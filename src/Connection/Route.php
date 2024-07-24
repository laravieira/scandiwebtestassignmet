<?php

namespace STA\Connection;

use ArgumentCountError;
use STA\STAException;

class Route
{
    public string $regex;
    public array $paramsMetadata = array();
    public array $params = array();
    public Response $response;
    /**
     * Create a Route and add it to be callable by call() method.
     *
     * The pattern can include REST API GET args like:
     * * **get string:** [s:get_name]
     * * **get int:** [i:get_name]
     * * **get float:** [f:get_name]
     * * **get bool:** [b:get_name]
     *
     * One pattern example is:
     * > /product/[s:sku]/price/[f:price]/update
     *
     * That patter will recognise paths and catch these params like:
     * 1. /product/HJ3HJ7HDF/price/12.32/update
     *      * string $sku = 'HJ3HJ7HDF';
     *      * float $price = 12.32f;
     * 2. /product/HJ3547543/price/0/update
     *      * string $sku = 'HJ3547543';
     *      * float $price = 0f;
     *
     * **Default Values:**
     * $type = 'GET'
     * $homeRedirect = false
     * @param string $pattern The pattern rule to call the route
     * @param string|array $callback The method to call when the route is called
     * @param string $type The request type to this route
     * @param bool $homeRedirect If this route will redirect to the home redirect
     */
    public function __construct(
        public string $pattern,
        public string|array $callback,
        public string $type = 'GET',
        public bool $homeRedirect = false
    ) {
        $this->regex = '/' . str_replace('/', '\/', $pattern) . '/';
        $this->parseGetParams();
        $this->params += $_POST;
    }

    /**
     * Converts the given pattern to regex expression, save the get arg names
     * and types to future parse and conversion when the route be called.
     *
     * The regex expression and the args metadata are saved on the $regex and
     * $paramsMetadata Route's properties respectively.
     */
    private function parseGetParams(): void {
        /* This regex makes easy to collect get params through REST API path pattern
         * I didn't use any get params, but seems right implement it
         *
         * For a given path like "/api/sku/[s:sku]/change/[i:price]"
         * the regex below will return an array as:
         * [
         *     ["[s:sku]", "s", "sku"],
         *     ["[i:price]", "i", "price"]
         * ]
         * Maybe, someday, I will look at these commentaries as unnecessary,
         * but today regex is pretty confusing to me. And I used
         * https://regex101.com/ to build that regex rule.
        */

        $regexPattern = '/\[([s|i|f|b])\:(\w+)\]/';
        if(!preg_match_all($regexPattern, $this->pattern, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $index => $match) {
                switch($match[1]) {
                    case 's': // for string params
                        $this->regex = str_replace($match[0], '(\w+)', $this->regex);
                        $this->paramsMetadata[$index] = array(
                            'name' => $match[2],
                            'type' => $match[1]
                        );
                        break;
                    case 'i': // for int params
                        $this->regex = str_replace($match[0], '(\d+)', $this->regex);
                        $this->paramsMetadata[$index] = array(
                            'name' => $match[2],
                            'type' => $match[1]
                        );
                        break;
                    case 'f': // for float params
                        $this->regex = str_replace($match[0], '(\w+)', $this->regex);
                        $this->paramsMetadata[$index] = array(
                            'name' => $match[2],
                            'type' => $match[1]
                        );
                        break;
                    case 'b': // for bool params
                        $this->regex = str_replace($match[0], '([true|false])', $this->regex);
                        $this->paramsMetadata[$index] = array(
                            'name' => $match[2],
                            'type' => $match[1]
                        );
                        break;
                }
            }
        }
    }


    /**
     * Compares if the given path matches the pattern of this Route.
     *
     * If matches return all the matches, if not, return false.
     * @param string $path Path to compare
     * @return bool|array If the path matches the route pattern
     */
    public function isPathEquals(string $path): bool|array
    {
        if (!preg_match($this->regex, $path, $params) || $params[0] != $path)
            return false;
        return $params;
    }

    /**
     * Load all params to the args, converting to they claimed type specified
     * on the Route pattern and associating they name.
     * @param array $params The get args values to load
     */
    public function loadParams(array $params): void
    {
        foreach ($params as $key => $value) {
            $name = $this->paramsMetadata[$key]['name'];
            $type = $this->paramsMetadata[$key]['type'];

            $this->params[$name] = match($type) {
                's' => $value,
                'i' => intval($value),
                'f' => floatval($value),
                'b' => ($value == 'true'),
            };
        }
    }


    /**
     * Call the route callback passing the get & post parameters.
     * The callback response is sent to the client including if an
     * STA error occur.
     *
     * If $homeRedirect is set to true, the return will be a redirect to the home page.
     *
     * If there are parameters missing, an error message will be the response to the client.
     */
    public function call(): void
    {
        $response = null;
        try {
            $result = call_user_func_array($this->callback, $this->params);
            $response = new Response($result, 200);
        } catch (ArgumentCountError) {
            if($this->homeRedirect) {
                $exception = new STAException('Too few arguments on request', 400);
                $response = new Response($exception->respond(), $exception->getCode());
            }
        }
       if ($this->homeRedirect) {
            $response = new Response(
                content: '',
                code: 303,
                type: Response::REDIRECT,
                headers: array('Location' => '/')
            );
        }
       $response->send();
    }
}