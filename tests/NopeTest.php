<?php /** @noinspection DuplicatedCode */

/** @noinspection ClassConstantCanBeUsedInspection */


namespace Tests;

use Amirhs712\RuleBuilder\Nope;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use PhpParser\Node\Stmt\Nop;
use stdClass;

class NopeTest extends \PHPUnit\Framework\TestCase
{
    public static function testProxyRules()
    {
        self::assertEquals('in:"1","2","3"', Nope::in([1, 2, 3])->get());
        self::assertEquals('not_in:"1","2","3"', Nope::notIn([1, 2, 3])->get());
        self::assertEquals('dimensions:width=1,height=2', Nope::dimensions(['width' => 1, 'height' => 2])->get());
        self::assertEquals('exists:mysql.users,username', Nope::exists('mysql.users', 'username')->get());
        self::assertEquals('exists:users,username', Nope::exists('App\Models\User', 'username')->get());
        self::assertEquals('unique:table,column,"ignoredId",ignoredColumn', Nope::unique
        (Rule::unique('table', 'column')->ignore('ignoredId', 'ignoredColumn'))->get());
    }

    public static function testProxyRulesWithInstances()
    {
        self::assertEquals('in:"1","2","3"', Nope::in(Rule::in([1, 2, 3]))->get());
        self::assertEquals('not_in:"1","2","3"', Nope::notIn(Rule::notIn([1, 2, 3]))->get());
        self::assertEquals('dimensions:width=1,height=2', Nope::dimensions(Rule::dimensions(['width' => 1])->height(2))->get());
        self::assertEquals('exists:mysql.users,username', Nope::exists(Rule::exists('mysql.users', 'username'))->get());
        self::assertEquals('exists:users,username', Nope::exists(Rule::exists('App\Models\User', 'username'))->get());
        self::assertEquals('unique:table,column,"ignoredId",ignoredColumn', Nope::unique
        (Rule::unique('table', 'column')->ignore('ignoredId', 'ignoredColumn'))->get());
    }


    public static function testRequiredIf()
    {
        $trueCallback = function () {
            return true;
        };

        self::assertEquals('requiredIf:a,b', Nope::requiredIf('a', 'b')->get());
        self::assertEquals('required', Nope::requiredIf(true, 'John Doe')->get());
        self::assertEquals('', Nope::requiredIf(Rule::requiredIf(false))->get());

        self::assertEquals('required', Nope::requiredIf(Rule::requiredIf($trueCallback))->get());
        self::assertEquals('required', Nope::requiredIf($trueCallback)->get());
    }

    public static function testToArrayOutput()
    {
        $object = new stdClass();
        self::assertEquals(['string', $object, 'sometimes', 'nullable'], Nope::string()->raw($object)->toArray(-2));
    }

    public static function testDateRules()
    {
        $date = Carbon::now();
        self::assertEquals("before:" . $date->toIso8601String(), Nope::before($date)->get());
        self::assertEquals("before_or_equal:" . $date->toIso8601String(), Nope::beforeOrEqual($date)->get());
        self::assertEquals("date_equals:" . $date->toIso8601String(), Nope::dateEquals($date)->get());
        self::assertEquals("date_equals:tomorrow", Nope::dateEquals('tomorrow')->get());
        self::assertEquals("after:" . $date->toIso8601String(), Nope::after($date)->get());
        self::assertEquals("after_or_equal:" . $date->toIso8601String(), Nope::afterOrEqual($date)->get());
    }


}
