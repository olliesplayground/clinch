<?php


namespace Clinch;


class Option
{
    /**
     * @var string
     */
    private $longName;

    /**
     * @var string
     */
    private $shortName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Argument
     */
    private $argument;


    /**
     * Option constructor.
     * @param string|null $longName
     */
    public function __construct(string $longName = null)
    {
        if ($longName) {
            $this->setLongName($longName);
        }
    }

    /**
     * @param string $longName
     * @return Option
     */
    public function setLongName(string $longName): Option
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * @param string $shortName
     * @return Option
     */
    public function setShortName(string $shortName): Option
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @param $description
     * @return Option
     */
    public function setDescription($description): Option
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param Argument $argument
     * @return Option
     */
    public function setArgument(Argument $argument): Option
    {
        $this->argument = $argument;

        return $this;
    }

    /**
     * @return string
     */
    public function longName(): string
    {
        return $this->longName;
    }

    /**
     * @return string|null
     */
    public function shortName(): ?string
    {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return Argument|null
     */
    public function argument(): ?Argument
    {
        return $this->argument;
    }
}
