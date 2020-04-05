<?php


namespace Clinch;


use ReflectionClass;

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
     * @var int
     */
    private $type = self::TYPE_OPTIONAL;

    /**
     * @var string
     */
    private $value;

    public const TYPE_FLAG = 0;
    public const TYPE_OPTIONAL = 1;
    public const TYPE_REQUIRED = 2;


    /**
     * Option constructor.
     * @param string|null $shortName
     */
    public function __construct(string $shortName = null)
    {
        if ($shortName) {
            $this->setShortName($shortName);
        }
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
     * @param string $longName
     * @return Option
     */
    public function setLongName(string $longName): Option
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * @param mixed $value
     * @return Option
     */
    public function setValue($value): Option
    {
        $this->value = $value;

        return $this;
    }

    public function setType(int $type): Option
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        $constants = $reflectionClass->getConstants();

        $this->type = in_array($type, $constants, true) ?
            $type :
            self::TYPE_OPTIONAL;

        return $this;
    }

    /**
     * @return string
     */
    public function shortName(): string
    {
        return $this->shortName;
    }

    /**
     * @return string|null
     */
    public function longName(): ?string
    {
        return $this->longName;
    }

    /**
     * @return int
     */
    public function type(): int
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        if ( $this->value === null ) {
            $this->setValue( $this->getValue() );
        }

        return $this->value;
    }

    /**
     * @return string
     */
    public function compileShortOption(): string
    {
        $short  = $this->shortName();

        if ($this->type() === self::TYPE_OPTIONAL) {
            $short .= '::';
        } else if ($this->type() === self::TYPE_REQUIRED) {
            $short .= ':';
        }

        return $short;
    }

    /**
     * @return array
     */
    public function compileLongOption(): array
    {
        $long = [];

        if ($this->longName()) {
            $longOption = $this->longName;

            if ($this->type() === self::TYPE_OPTIONAL) {
                $longOption .= '::';
            } else if ($this->type() === self::TYPE_REQUIRED) {
                $longOption .= ':';
            }

            $long[] = $longOption;
        }

        return $long;
    }

    public function parseValues(array $values)
    {
        if ( array_key_exists($this->shortName(), $values) ) {
            return $this->type() === self::TYPE_FLAG ? true : $values[$this->shortName()];
        }

        if ( $this->longName() && array_key_exists($this->longName(), $values) ) {
            return $this->type() === self::TYPE_FLAG ? true : $values[$this->longName()];
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $short  = $this->compileShortOption();

        $long = $this->compileLongOption();

        return $this->parseValues(getopt($short, $long));
    }
}
