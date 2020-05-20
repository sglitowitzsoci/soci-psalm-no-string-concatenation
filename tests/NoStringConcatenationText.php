<?php

    namespace SOCi\Psalm\Plugin\Tests;

    use SOCi\Psalm\Plugin\NoStringConcatenation;
    use SimpleXMLElement;
    use PHPUnit\Framework\TestCase;
    use Prophecy\Prophecy\ObjectProphecy;
    use Psalm\Plugin\RegistrationInterface;

class NoStringConcatenationText extends TestCase
{
    /**
     * @var string
     */
    private $member_variable = 'a';
    /**
     * @var ObjectProphecy
     */
    private $registration;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->registration = $this->prophesize(RegistrationInterface::class);
    }

    /**
     * @test
     * @return void
     */
    public function hasEntryPoint()
    {
        $this->expectNotToPerformAssertions();
        $plugin = new NoStringConcatenation();
        $plugin($this->registration->reveal(), null);
    }

    /**
     * @test
     * @return void
     */
    public function acceptsConfig()
    {
        $this->expectNotToPerformAssertions();
        $plugin = new NoStringConcatenation();
        $plugin($this->registration->reveal(), new SimpleXMLElement('<myConfig></myConfig>'));
    }

    /**
     * @return void
     */
    public function detectsStringConcatenation()
    {
        $literal_literal_concatenation = "Hello " . "World";
        $world = "World";
        $literal_variable_concatenation = "Hello " . $world;
        $literal_member_variable_concatenation = "Hello " . $this->member_variable;
        $literal_member_function_concatenation = "Hello " . $this->getString();
    }

    private function getString(): string
    {
        return "string";
    }
}
