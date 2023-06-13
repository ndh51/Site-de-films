<?php

declare(strict_types=1);

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

class WebPage
{
    /* Attributs */

    private string $head = "";
    private string $title = "";
    private string $body = "";


    /* Constructeur */

    /**
     * @param string $title
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /* Accesseurs */

    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }



    /* Setters */

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }



    /* Autres */

    /**
     * @param string $content
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= <<<HTML
            {$content}
            HTML;
    }

    /**
     * @param string $css
     * @return void
     */
    public function appendCss(string $css): void
    {
        if ((!str_contains($this->getHead(), '<style>') && str_contains($this->getHead(), '</style>')) || (str_contains($this->getHead(), '<style>') && !str_contains($this->getHead(), '</style>'))) {
            throw new Exception("Un problème a été repéré dans l'insertion des balises CSS");
        } elseif (!str_contains($this->getHead(), '<style>') && !str_contains($this->getHead(), '</style>')) {
            $this->head = $this->getHead() . <<<HTML
            
                    <style>
                    {$css}
                    </style>
            HTML;
        } elseif (str_contains($this->getHead(), '<style>') && str_contains($this->getHead(), '</style>')) {
            $this->head = $this->getHead() . <<<CSS
            
                    {$css}
            CSS;
        }
    }

    /**
     * @param string $url
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->head = $this->getHead() . <<<HTML
                <link rel="stylesheet" href="{$url}">
            HTML;
    }

    /**
     * @param string $js
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->head = $this->getHead() . <<<HTML
                    
                    <script>
                    {$js}
                    </script>
            HTML;
    }

    /**
     * @param string $url
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->head = $this->getHead() . <<<HTML
                    
                    <script src="{$url}"></script>
            HTML;
    }

    /**
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body = $this->getBody() . <<<HTML
            {$content}
            HTML;

    }

    /**
     * @return string
     */
    public function toHTML(): string
    {


        $title = $this->getTitle();
        $head = $this->getHead();
        $body = $this->getBody();

        $html = <<<HTML
            <!doctype html>
            <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>{$title}</title>
                {$head}
                </head>
                <body>
                {$body}
                </body>
            </html>
            HTML;

        return $html;
    }

    /**
     * @param string $string
     * @return string
     */
    public function escapeString(string $string): string
    {
        $string = htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
        return $string;
    }

    /**
     * @return string
     */
    public static function getLastModification(): string
    {
        return "Dernière modification : " . date("d/m/Y - H:i:s", getlastmod());
    }

}
