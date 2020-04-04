<?php


namespace Clinch;


class Options
{
    /**
     * @var Option[]
     */
    private $options = [];

    /**
     * @var Argument[]
     */
    private $arguments = [];

    public function __construct()
    {
        $this->parseArgs();
    }

    /**
     * @param array|null $args
     */
    public function parseArgs(array $args = null): void
    {
        $arguments = $args ?? $_SERVER['argv'];

        /**
         * Remove executed script
         */
        array_shift($arguments);

        foreach ($arguments as $argument) {
            $this->arguments[] = new Argument($argument);
        }
    }

    /**
     * @return Argument[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param Option $option
     * @param string $longName
     * @return Option
     */
    public function addOption(Option $option, string $longName): Option
    {
        if ($this->optionExists($longName)) {
            return $this->options[$longName];
        }

        $this->options[$longName] = $option;

        return $option;
    }

    /**
     * @param string $longName
     * @return Option
     */
    public function newOption(string $longName): Option
    {
        if ($this->optionExists($longName)) {
            return $this->options[$longName];
        }

        $option = new Option($longName);

        return $this->addOption($option, $longName);
    }

    /**
     * @param string $longName
     * @return bool
     */
    public function optionExists(string $longName): bool
    {
        return array_key_exists($longName, $this->options);
    }

    /**
     * @param string $longName
     * @return Option|null
     */
    public function getOption(string $longName): ?Option
    {
        if (!array_key_exists($longName, $this->options)) {
            return null;
        }

        return $this->options[$longName];
    }

    /**
     * @param string $longName
     * @return mixed
     */
    public function getOptionValue(string $longName)
    {
        $option = $this->getOption($longName);

        if ( $option === null ) {
            return null;
        }

        $argumentSet = $this->matchArgumentToOption($option);

        return $argumentSet ? $option->argument()->getValue() : null;
    }

    /**
     * @param Option $option
     * @return bool
     */
    public function matchArgumentToOption(Option $option): bool
    {
        $argumentSet = true;

        if ($option->argument() === null) {
            $argumentSet = false;
            /** @var $argument Argument */
            foreach ($this->arguments as $argument) {
                if ($argument->getType() === Argument::TYPE_FLAG) {
                    $argument->setValue(true);
                    $option->setArgument($argument);
                    $argumentSet = true;
                    break;
                }

                if ($argument->getType() === Argument::TYPE_LONG && $argument->getName() === $option->longName()) {
                    $option->setArgument($argument);
                    $argumentSet = true;
                    break;
                }

                if ($option->shortName() !== null && $argument->getType() === Argument::TYPE_SHORT && strpos($argument->getName(), $option->shortName()) === 0) {
                    $argument->setValue(substr($argument->getName(), strlen($option->shortName())));
                    $option->setArgument($argument);
                    $argumentSet = true;
                    break;
                }
            }
        }

        return $argumentSet;
    }
}
