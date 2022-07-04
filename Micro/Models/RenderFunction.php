<?php


namespace API\Models;


class RenderFunction
{
    public string $name;
    private array $callable;

    public function __construct(string $name, array $callable)
    {
        $this->name = $name;
        $this->callable = $callable;
    }
    public function getClass(): object
    {
        return $this->callable[0];
    }
    public function getMethod(): string
    {
        return $this->callable[1];
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}