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
        self::assertEquals('in:"1","2","3"', nope()->in([1, 2, 3])->get());
        self::assertEquals('not_in:"1","2","3"', nope()->notIn([1, 2, 3])->get());
        self::assertEquals('dimensions:width=1,height=2', nope()->dimensions(['width' => 1, 'height' => 2])->get());
        self::assertEquals('exists:mysql.users,username', nope()->exists('mysql.users', 'username')->get());
        self::assertEquals('exists:users,username', nope()->exists('App\Models\User', 'username')->get());
        self::assertEquals('unique:table,column,"ignoredId",ignoredColumn', nope()->unique
        (Rule::unique('table', 'column')->ignore('ignoredId', 'ignoredColumn'))->get());
    }

    public static function testProxyRulesWithInstances()
    {
        self::assertEquals('in:"1","2","3"', nope()->in(Rule::in([1, 2, 3]))->get());
        self::assertEquals('not_in:"1","2","3"', nope()->notIn(Rule::notIn([1, 2, 3]))->get());
        self::assertEquals('dimensions:width=1,height=2', nope()->dimensions(Rule::dimensions(['width' => 1])->height(2))->get());
        self::assertEquals('exists:mysql.users,username', nope()->exists(Rule::exists('mysql.users', 'username'))->get());
        self::assertEquals('exists:users,username', nope()->exists(Rule::exists('App\Models\User', 'username'))->get());
        self::assertEquals('unique:table,column,"ignoredId",ignoredColumn', nope()->unique
        (Rule::unique('table', 'column')->ignore('ignoredId', 'ignoredColumn'))->get());
    }


    public static function testRequiredIf()
    {
        $trueCallback = function () {
            return true;
        };

        self::assertEquals('requiredIf:a,b', nope()->requiredIf('a', 'b')->get());
        self::assertEquals('required', nope()->requiredIf(true, 'John Doe')->get());
        self::assertEquals('', nope()->requiredIf(Rule::requiredIf(false))->get());

        self::assertEquals('required', nope()->requiredIf(Rule::requiredIf($trueCallback))->get());
        self::assertEquals('required', nope()->requiredIf($trueCallback)->get());
    }

    public static function testToArrayOutput()
    {
        $object = new stdClass();
        self::assertEquals(['string', $object, 'sometimes', 'nullable'], nope()->string()->raw($object)->toArray(-2));
    }

    public static function testDateRules()
    {
        $date = Carbon::now();
        self::assertEquals("before:" . $date->toIso8601String(), nope()->before($date)->get());
        self::assertEquals("before_or_equal:" . $date->toIso8601String(), nope()->beforeOrEqual($date)->get());
        self::assertEquals("date_equals:" . $date->toIso8601String(), nope()->dateEquals($date)->get());
        self::assertEquals("date_equals:tomorrow", nope()->dateEquals('tomorrow')->get());
        self::assertEquals("after:" . $date->toIso8601String(), nope()->after($date)->get());
        self::assertEquals("after_or_equal:" . $date->toIso8601String(), nope()->afterOrEqual($date)->get());
    }

    public function testMinMaxRules()
    {
        self::assertEquals('string|min:1|max:2', nope()->string(1,2)->get());
        self::assertEquals('alpha_dash|min:1|max:2', nope()->alphaDash(1,2)->get());
        self::assertEquals('json|max:30', nope()->json(30)->get());
    }
}
