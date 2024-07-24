<?php

namespace STA\Connection;

class Response
{
    const JSON = 0;
    const HTML = 1;
    const REDIRECT = 2;

    /**
     * Build a response builder to send parsed responses to the client.
     *
     * **Default Values:**
     * $code = 200
     * $type = Response::JSON
     * @param mixed $content The content of the response
     * @param int $code The HTTP code of the response
     * @param int $type The content type of the response
     * @param array $headers Optional additional headers to the response
     */
    public function __construct(
        private mixed $content,
        private int $code = 200,
        private int $type = self::JSON,
        private array $headers = array()
    ) {}

    /**
     * Send (or print) the response to the client browser,
     * when this is called the headers are sent, so you can't
     * do it more than 1 time per request.
     */
    public function send(): void
    {
        switch($this->type) {
            case self::HTML:
                $this->sendHTML();
                break;
            case self::REDIRECT:
                $this->sendResponse('');
                break;
            default: $this->sendJSON();
        }
    }


    /**
     * Send the content-type header with value:
     *
     * text/html; charset=UTF-8
     *
     * And then send the content.
     */
    private function sendHTML(): void
    {
        $this->headers['Content-type'] = "text/html; charset=UTF-8";
        $this->sendResponse($this->content);
    }

    /**
     * Send the content-type header with value:
     *
     * application/json; charset=UTF-8
     *
     * And then send the content.
     */
    private function sendJSON(): void
    {
        $this->headers['Content-type'] = "application/json; charset=UTF-8";
        $this->sendResponse(json_encode($this->content));
    }

    /**
     * Send additional headers, set response code and send the
     * content response.
     * @param mixed $content Content of the response
     */
    private function sendResponse(mixed $content): void
    {
        http_response_code($this->code);
        foreach ($this->headers as $name => $value)
            header("$name: $value");
        echo $content;
    }
}