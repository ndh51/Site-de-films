<?php

namespace Html;

class WebPage
{
    private string $head;
    private string $title;
    private string $body;

    public function __Construct(string $title = '')
    {
        $this->title = $title;
        $this->head = '';
        $this->body = '';
    }

    /**
     * @param string $head
     */
    public function setHead($head)
    {
        $this->head = $head;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


    /**
     * @return string
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    public function appendContent(string $content)
    {
        $this->body .= $content;
    }

    public function escapeString(string $str)
    {
        $strg = htmlspecialchars($str, ENT_QUOTES | ENT_XHTML);
        return $strg;
    }

    public function appendToHead(string $content)
    {
        $this->head .= $content;
    }

    public function toHTML()
    {
        $res = ' <!DOCTYPE html> <html lang="fr"> <head> <meta name="viewport" charset="utf-8"><title>' . $this->gettitle() . '</title> ' . $this->getHead();
        $res .= '<body> ' . $this->getbody() . '</body> </html>';

        return $res;
    }

    public function appendCss(string $css)
    {
        $this->appendToHead('<style>' . $css . '</style>');
    }

    public function appendCssUrl(string $url)
    {
        $this->appendToHead('<link href="' . $url . '" rel="stylesheet">');
    }

    public function appendJs(string $js)
    {
        $this->appendToHead('<script type="text/javascript">' . $js . '</script>');
    }

    public function appendJsUrl(string $js)
    {
        $this->appendToHead('<script type="text/javascript" src="' . $js . '"></script>');
    }
}
