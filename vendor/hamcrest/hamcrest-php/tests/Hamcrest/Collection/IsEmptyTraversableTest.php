<?php
namespace Hamcrest\Collection;

use Hamcrest\AbstractMatcherTest;

class IsEmptyTraversableTest extends AbstractMatcherTest
{

    protected function createMatcher()
    {
        return IsEmptyTraversable::emptyTraversable();
    }

    public function testEmptyMatcherMatchesWhenEmpty()
    {
        $this->assertMatches(
            emptyTraversable(),
            new \ArrayObject([]),
            'an empty traversable'
        );
    }

    public function testEmptyMatcherDoesNotMatchWhenNotEmpty()
    {
        $this->assertDoesNotMatch(
            emptyTraversable(),
            new \ArrayObject([1, 2, 3]),
            'a non-empty traversable'
        );
    }

    public function testEmptyMatcherDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(
            emptyTraversable(),
            null,
            'should not match null'
        );
    }

    public function testEmptyMatcherHasAReadableDescription()
    {
        $this->assertDescription('an empty traversable', emptyTraversable());
    }

    public function testNonEmptyDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(
            nonEmptyTraversable(),
            null,
            'should not match null'
        );
    }

    public function testNonEmptyDoesNotMatchWhenEmpty()
    {
        $this->assertDoesNotMatch(
            nonEmptyTraversable(),
            new \ArrayObject([]),
            'an empty traversable'
        );
    }

    public function testNonEmptyMatchesWhenNotEmpty()
    {
        $this->assertMatches(
            nonEmptyTraversable(),
            new \ArrayObject([1, 2, 3]),
            'a non-empty traversable'
        );
    }

    public function testNonEmptyNonEmptyMatcherHasAReadableDescription()
    {
        $this->assertDescription('a non-empty traversable', nonEmptyTraversable());
    }
}
