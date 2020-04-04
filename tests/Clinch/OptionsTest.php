<?php


namespace Clinch\Test;


use Clinch\Option;
use Clinch\Options;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testAddOption(): void
    {
        $options = new Options();

        $this->assertCount(0, $options->getOptions());

        $newOption = new Option('t');

        $options->addOption(
            $newOption,
            't'
        );

        $optionsArray = $options->getOptions();

        $this->assertCount(1, $optionsArray);

        $this->assertEquals($newOption, $optionsArray['t']);
    }

    public function testNewOption(): void
    {
        $options = new Options();

        $this->assertCount(0, $options->getOptions());

        $options->newOption('f');

        $optionsArray = $options->getOptions();

        $this->assertCount(1, $optionsArray);

        $this->assertInstanceOf(Option::class, $optionsArray['f']);
    }

    public function testOptionExists(): void
    {
        $options = new Options();

        $options->newOption('f');

        $this->assertTrue($options->optionExists('f'));

        $this->assertFalse($options->optionExists('n'));
    }

    public function testGetOptions(): void
    {
        $options = new Options();

        $optionsArray = $options->getOptions();

        $this->assertCount(0, $optionsArray);

        $options->newOption('f');

        $optionsArray = $options->getOptions();

        $this->assertCount(1, $optionsArray);
    }

    public function testGetOption(): void
    {
        $options = new Options();

        $newOption = new Option('t');

        $options->addOption(
            $newOption,
            't'
        );

        $option = $options->getOption('t');

        $this->assertEquals($newOption, $option);
    }

    public function testGetOptionValue(): void
    {
        $options = new Options();

        $option = new Option('t');
        $option->setValue(123);

        $options->addOption($option, 't');

        $this->assertEquals(123, $options->getOptionValue('t'));
    }
}
