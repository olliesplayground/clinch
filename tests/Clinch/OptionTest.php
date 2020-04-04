<?php


namespace Clinch\Test;


use Clinch\Option;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testShortName(): void
    {
        $option = new Option();

        $option->setShortName('s');

        $this->assertEquals('s', $option->shortName());
    }

    public function testLongName(): void
    {
        $option = new Option();

        $option->setLongName('longName');

        $this->assertEquals('longName', $option->longName());
    }

    public function testValue(): void
    {
        $option = new Option();

        $option->setValue(123);

        $this->assertEquals(123, $option->value());
    }

    public function testType(): void
    {
        $option = new Option();

        $option->setType(Option::TYPE_FLAG);

        $this->assertEquals(Option::TYPE_FLAG, $option->type());
    }

    public function testCompileShortOption(): void
    {
        $option = new Option('t');

        $opt = $option->compileShortOption();

        $this->assertEquals('t::', $opt);

        $option->setType(Option::TYPE_REQUIRED);

        $opt = $option->compileShortOption();

        $this->assertEquals('t:', $opt);

        $option->setType(Option::TYPE_FLAG);

        $opt = $option->compileShortOption();

        $this->assertEquals('t', $opt);
    }

    public function testCompileLongOption(): void
    {
        $option = new Option('t');
        $option->setLongName('test');

        $opt = $option->compileLongOption();

        $this->assertEquals(['test::'], $opt);

        $option->setType(Option::TYPE_REQUIRED);

        $opt = $option->compileLongOption();

        $this->assertEquals(['test:'], $opt);

        $option->setType(Option::TYPE_FLAG);

        $opt = $option->compileLongOption();

        $this->assertEquals(['test'], $opt);
    }

    public function testParseValues(): void
    {
        $option = new Option('t');

        $values = [
            't' => 123
        ];

        $this->assertEquals(123, $option->parseValues($values));

        $option = new Option('t');
        $option->setLongName('test');

        $values = [
            'test' => 123
        ];

        $this->assertEquals(123, $option->parseValues($values));

        $option = new Option('t');
        $option->setType(Option::TYPE_FLAG);

        $values = [
            't' => false
        ];

        $this->assertEquals(true, $option->parseValues($values));

        $option = new Option('f');

        $values = [
            't' => 123
        ];

        $this->assertEquals(false, $option->parseValues($values));
    }
}
