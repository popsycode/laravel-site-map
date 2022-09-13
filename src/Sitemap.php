<?php

namespace Popsy\LaravelSiteMap;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\View\Factory as ViewFactory;
use SiteMap\GeneratorFactory;
use SiteMap\IGenerator;

class Sitemap
{
    private IGenerator $generator;
    private ConfigRepository $config;

    public function __construct(IGenerator $generator, ConfigRepository $config)
    {
        $this->generator = $generator;
        $this->config = $config;
    }

    public function setType(string $type): self
    {
        $this->setGenerator($type);
        return $this;
    }

    public function setData(array $data): self{
        $this->generator->setData($data);
        return $this;
    }

    public function setFilePath(string $path): self{
        $this->generator->setFilePath($path);
        return $this;
    }

    public function generate(): void {
        $this->generator->generate();
    }

    /**
     * @return IGenerator
     */
    public function getGenerator(): IGenerator
    {
        return $this->generator;
    }

    /**
     * @param  IGenerator|string  $generator
     */
    public function setGenerator(IGenerator|string $generator): void
    {
        if(is_string($generator))
            $generator = (new GeneratorFactory())->createGenerator($generator);
        $this->generator = $generator;
    }

    /**
     * Dynamically handle calls into the sitemap instance.
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return $this|mixed
     */
    public function __call(string $method, array $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->$method(...$parameters);
        }

        if (method_exists($this->generator, $method)) {
            $return = $this->generator->$method(...$parameters);

            return $return == $this->generator ? $this : $return;
        }

        throw new \UnexpectedValueException("Method [{$method}] does not exist on Sitemap instance.");
    }



}
