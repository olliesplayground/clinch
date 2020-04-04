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

    public function testParseArgs(): void
    {
        $options = new Options();

        $this->assertCount(0, $options->getArguments());

        $args = [
            'script.ext',
            '--arg1=val1',
            '-a2val2'
        ];

        $options->parseArgs($args);

        $this->assertCount(2, $options->getArguments());
    }

    public function testAddOption(): void
    {
        $options = new Options();

        $options->addOption(
            new Option('test'),
            'test'
        );

    }
}
