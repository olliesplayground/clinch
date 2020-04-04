<?php


namespace Clinch;


class Argument
{
    /**
     * @var string
     */
    private $argument;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    public const TYPE_FLAG = '';
    public const TYPE_SHORT = '-';
    public const TYPE_LONG = '--';

    /**
     * Argument constructor.
     * @param string $argument
     */
    public function __construct(string $argument)
    {
        $this->argument = $argument;

        $this->parse($argument);
    }

    /**
     * @param $argument
     */
    public function parse($argument): void
    {
        if (strpos($argument, '-') === 0) {
            $matches = [];

            if (!preg_match('/(?P<type>\-{1,2})(?P<name>[a-z][a-z0-9_=-]*)/i', $argument, $matches)) {
                return;
            }

            $this->type = $matches['type'];
            $this->name = $matches['name'];

            if ($this->getType() === self::TYPE_LONG) {
                [$name, $value] = explode('=', $this->getName());

                $this->name = $name;
                $this->value = $value;
            }
        } else {
            $this->type = self::TYPE_FLAG;
            $this->name = $argument;
        }
    }

    /**
     * @return string
     */
    public function getArgument(): string
    {
        return $this->argument;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return Argument
     */
    public function setValue($value): Argument
    {
        $this->value = $value;

        return $this;
    }
}
