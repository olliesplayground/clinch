<?php


namespace Clinch;


class Options
{
    /**
     * @var Option[]
     */
    private $options = [];

    /**
     * @param Option $option
     * @param string $shortName
     * @return Option
     */
    public function addOption(Option $option, string $shortName): Option
    {
        if ($this->optionExists($shortName)) {
            return $this->options[$shortName];
        }

        $this->options[$shortName] = $option;

        return $option;
    }

    /**
     * @param string $shortName
     * @return Option
     */
    public function newOption(string $shortName): Option
    {
        if ($this->optionExists($shortName)) {
            return $this->options[$shortName];
        }

        $option = new Option($shortName);

        return $this->addOption($option, $shortName);
    }

    /**
     * @param string $shortName
     * @return bool
     */
    public function optionExists(string $shortName): bool
    {
        return array_key_exists($shortName, $this->options);
    }

    /**
     * @return Option[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $shortName
     * @return Option|null
     */
    public function getOption(string $shortName): ?Option
    {
        if (!array_key_exists($shortName, $this->options)) {
            return null;
        }

        return $this->options[$shortName];
    }

    /**
     * @param string $shortName
     * @return mixed
     */
    public function getOptionValue(string $shortName)
    {
        $option = $this->getOption($shortName);

        return $option === null ? null : $option->value();
    }
}
