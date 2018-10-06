<?php
namespace Hamcrest\Arrays;

use Hamcrest\AbstractMatcherTest;

class IsArrayContainingInAnyOrderTest extends AbstractMatcherTest
{

    protected function createMatcher()
    {
        return IsArrayContainingInAnyOrder::arrayContainingInAnyOrder([1, 2]);
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('[<1>, <2>] in any order', containsInAnyOrder([1, 2]));
    }

    public function testMatchesItemsInAnyOrder()
    {
        $this->assertMatches(containsInAnyOrder([1, 2, 3]), [1, 2, 3], 'in order');
        $this->assertMatches(containsInAnyOrder([1, 2, 3]), [3, 2, 1], 'out of order');
        $this->assertMatches(containsInAnyOrder([1]), [1], 'single');
    }

    public function testAppliesMatchersInAnyOrder()
    {
        $this->assertMatches(
            containsInAnyOrder([1, 2, 3]),
            [1, 2, 3],
            'in order'
        );
        $this->assertMatches(
            containsInAnyOrder([1, 2, 3]),
            [3, 2, 1],
            'out of order'
        );
        $this->assertMatches(
            containsInAnyOrder([1]),
            [1],
            'single'
        );
    }

    public function testMismatchesItemsInAnyOrder()
    {
        $matcher = containsInAnyOrder([1, 2, 3]);

        $this->assertMismatchDescription('was null', $matcher, null);
        $this->assertMismatchDescription('No item matches: <1>, <2>, <3> in []', $matcher, []);
        $this->assertMismatchDescription('No item matches: <2>, <3> in [<1>]', $matcher, [1]);
        $this->assertMismatchDescription('Not matched: <4>', $matcher, [4, 3, 2, 1]);
    }
}
