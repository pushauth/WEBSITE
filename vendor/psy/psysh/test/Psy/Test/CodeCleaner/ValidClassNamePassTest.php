<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2015 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\CodeCleaner;

use Psy\CodeCleaner\ValidClassNamePass;
use Psy\Exception\Exception;

class ValidClassNamePassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new ValidClassNamePass());
    }

    /**
     * @dataProvider getInvalid
     */
    public function testProcessInvalid($code, $php54 = false)
    {
        try {
            $stmts = $this->parse($code);
            $this->traverse($stmts);
            $this->fail();
        } catch (Exception $e) {
            if ($php54 && version_compare(PHP_VERSION, '5.4', '<')) {
                $this->assertInstanceOf('Psy\Exception\ParseErrorException', $e);
            } else {
                $this->assertInstanceOf('Psy\Exception\FatalErrorException', $e);
            }
        }
    }

    public function getInvalid()
    {
        // class declarations
        return [
            // core class
            ['class stdClass {}'],
            // capitalization
            ['class stdClass {}'],

            // collisions with interfaces and traits
            ['interface stdClass {}'],
            ['trait stdClass {}', true],

            // collisions inside the same code snippet
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
                class Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
                trait Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
            ', true],
            ['
                trait Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
                class Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
            ', true],
            ['
                trait Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
                interface Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
            ', true],
            ['
                interface Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
                trait Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
            ', true],
            ['
                interface Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
                class Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
                interface Psy_Test_CodeCleaner_ValidClassNamePass_Alpha {}
            '],

            // namespaced collisions
            ['
                namespace Psy\\Test\\CodeCleaner {
                    class ValidClassNamePassTest {}
                }
            '],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    class Beta {}
                }
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    class Beta {}
                }
            '],

            // extends and implements
            ['class ValidClassNamePassTest extends NotAClass {}'],
            ['class ValidClassNamePassTest extends ArrayAccess {}'],
            ['class ValidClassNamePassTest implements stdClass {}'],
            ['class ValidClassNamePassTest implements ArrayAccess, stdClass {}'],
            ['interface ValidClassNamePassTest extends stdClass {}'],
            ['interface ValidClassNamePassTest extends ArrayAccess, stdClass {}'],

            // class instantiations
            ['new Psy_Test_CodeCleaner_ValidClassNamePass_Gamma();'],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    new Psy_Test_CodeCleaner_ValidClassNamePass_Delta();
                }
            '],

            // class constant fetch
            ['Psy\\Test\\CodeCleaner\\ValidClassNamePass\\NotAClass::FOO'],

            // static call
            ['Psy\\Test\\CodeCleaner\\ValidClassNamePass\\NotAClass::foo()'],
            ['Psy\\Test\\CodeCleaner\\ValidClassNamePass\\NotAClass::$foo()'],
        ];
    }

    /**
     * @dataProvider getValid
     */
    public function testProcessValid($code)
    {
        $stmts = $this->parse($code);
        $this->traverse($stmts);
    }

    public function getValid()
    {
        $valid = [
            // class declarations
            ['class Psy_Test_CodeCleaner_ValidClassNamePass_Epsilon {}'],
            ['namespace Psy\Test\CodeCleaner\ValidClassNamePass; class Zeta {}'],
            ['
                namespace { class Psy_Test_CodeCleaner_ValidClassNamePass_Eta {}; }
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    class Psy_Test_CodeCleaner_ValidClassNamePass_Eta {}
                }
            '],
            ['namespace Psy\Test\CodeCleaner\ValidClassNamePass { class stdClass {} }'],

            // class instantiations
            ['new stdClass();'],
            ['new stdClass();'],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    class Theta {}
                }
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    new Theta();
                }
            '],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    class Iota {}
                    new Iota();
                }
            '],
            ['
                namespace Psy\\Test\\CodeCleaner\\ValidClassNamePass {
                    class Kappa {}
                }
                namespace {
                    new \\Psy\\Test\\CodeCleaner\\ValidClassNamePass\\Kappa();
                }
            '],

            // Class constant fetch (ValidConstantPassTest validates the actual constant)
            ['class A {} A::FOO'],
            ['$a = new DateTime; $a::ATOM'],
            ['interface A { const B = 1; } A::B'],

            // static call
            ['DateTime::createFromFormat()'],
            ['DateTime::$someMethod()'],
            ['Psy\Test\CodeCleaner\Fixtures\ClassWithStatic::doStuff()'],
            ['Psy\Test\CodeCleaner\Fixtures\ClassWithCallStatic::doStuff()'],

            // Allow `self` and `static` as class names.
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function getInstance() {
                        return new self();
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function getInstance() {
                        return new SELF();
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function getInstance() {
                        return new self;
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function getInstance() {
                        return new static();
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function getInstance() {
                        return new Static();
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function getInstance() {
                        return new static;
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function foo() {
                        return parent::bar();
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function foo() {
                        return self::bar();
                    }
                }
            '],
            ['
                class Psy_Test_CodeCleaner_ValidClassNamePass_ClassWithStatic {
                    public static function foo() {
                        return static::bar();
                    }
                }
            '],

            ['class A { static function b() { return new A; } }'],
            ['
                class A {
                    const B = 123;
                    function c() {
                        return A::B;
                    }
                }
            '],
            ['class A {} class B { function c() { return new A; } }'],
        ];

        // Ugh. There's gotta be a better way to test for this.
        if (class_exists('PhpParser\ParserFactory')) {
            // PHP 7.0 anonymous classes, only supported by PHP Parser v2.x
            $valid[] = ['$obj = new class() {}'];
        }

        if (version_compare(PHP_VERSION, '5.5', '>=')) {
            $valid[] = ['interface A {} A::class'];
            $valid[] = ['interface A {} A::CLASS'];
            $valid[] = ['class A {} A::class'];
            $valid[] = ['class A {} A::CLASS'];
            $valid[] = ['A::class'];
            $valid[] = ['A::CLASS'];
        }

        return $valid;
    }
}
