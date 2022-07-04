<?php


namespace API\Models;


class NavEntry
{
    private string $type;
    private string $label;
    private string $icon;
    private array|string $link;
    private string $active;
    private array $separators;

    public function __construct(){
        $args = func_get_args();
        $this->type = (string)$args[0];
        $this->label = (string)$args[1];
        $this->icon = (string)$args[2];
        $this->link =  $args[3];
        $this->active =(string)$args[4];
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getLink(): array|string
    {
        return $this->link;
    }
    public function setLink(string $url)
    {
        $this->link = $url;
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

}