<?php /** @noinspection DuplicatedCode */

/** @noinspection ClassConstantCanBeUsedInspection */


namespace Tests;

use Amirhs712\RuleBuilder\Nope;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use PhpParser\Node\Stmt\Nop;
use RuntimeException;
use stdClass;

class NopeTest extends \PHPUnit\Framework\TestCase
{
    public function testProxyRules()
    {
        self::assertEquals('in:"1","2","3"', nope()->in([1, 2, 3])->toString());
        self::assertEquals('not_in:"1","2","3"', nope()->notIn([1, 2, 3])->toString());
        self::assertEquals('dimensions:width=1,height=2', nope()->dimensions(['width' => 1, 'height' => 2])->toString());
        self::assertEquals('exists:mysql.users,username', nope()->exists('mysql.users', 'username')->toString());
        self::assertEquals('exists:users,username', nope()->exists('App\Models\User', 'username')->toString());
        self::assertEquals('unique:table,column,"ignoredId",ignoredColumn', nope()->unique
        (Rule::unique('table', 'column')->ignore('ignoredId', 'ignoredColumn'))->toString());

        $this->expectException(RuntimeException::class);
        nope()->in(Rule::exists('users'))->get();
    }

    public static function testProxyRulesWithInstances()
    {
        self::assertEquals('in:"1","2","3"', nope()->in(Rule::in([1, 2, 3]))->toString());
        self::assertEquals('not_in:"1","2","3"', nope()->notIn(Rule::notIn([1, 2, 3]))->toString());
        self::assertEquals('dimensions:width=1,height=2', nope()->dimensions(Rule::dimensions(['width' => 1])->height(2))->toString());
        self::assertEquals('exists:mysql.users,username', nope()->exists(Rule::exists('mysql.users', 'username'))->toString());
        self::assertEquals('exists:users,username', nope()->exists(Rule::exists('App\Models\User', 'username'))->toString());
        self::assertEquals('unique:table,column,"ignoredId",ignoredColumn', nope()->unique
        (Rule::unique('table', 'column')->ignore('ignoredId', 'ignoredColumn'))->toString());
    }

    public static function testToArrayOutput()
    {
        $object = new stdClass();
        self::assertEquals(['string', $object, 'sometimes', 'nullable'], nope()->string()->raw($object)->get(-2));
    }

    //---------------------------------------- Test Custom Rules --------------------------------------------\\
    public static function testRequiredIf()
    {
        $trueCallback = function () {
            return true;
        };

        self::assertEquals('requiredIf:a,b', nope()->requiredIf('a', 'b')->toString());
        self::assertEquals('required', nope()->requiredIf(true, 'John Doe')->toString());
        self::assertEquals('', nope()->requiredIf(Rule::requiredIf(false))->toString());

        self::assertEquals('required', nope()->requiredIf(Rule::requiredIf($trueCallback))->toString());
        self::assertEquals('required', nope()->requiredIf($trueCallback)->toString());
    }

    public static function testDateRules()
    {
        $date = Carbon::now();
        $isoString = $date->toIso8601String();

        self::assertEquals("before:" . $isoString, nope()->before($date)->toString());
        self::assertEquals("before_or_equal:" . $isoString, nope()->beforeOrEqual($date)->toString());
        self::assertEquals("date_equals:" . $isoString, nope()->dateEquals($date)->toString());
        self::assertEquals("date_equals:tomorrow", nope()->dateEquals('tomorrow')->toString());
        self::assertEquals("after:" . $isoString, nope()->after($date)->toString());
        self::assertEquals("after_or_equal:" . $isoString, nope()->afterOrEqual($date)->toString());
    }

    public function testMinMaxRules()
    {
        self::assertEquals('alpha|min:1|max:2', nope()->alpha(1, 2)->toString());
        self::assertEquals('alpha_dash|min:1|max:2', nope()->alphaDash(1, 2)->toString());
        self::assertEquals('alpha_num|min:1|max:2', nope()->alphaNum(1, 2)->toString());
        self::assertEquals('array|min:1|max:2', nope()->array(1, 2)->toString());
        self::assertEquals('integer|min:1|max:2', nope()->integer(1, 2)->toString());
        self::assertEquals('numeric|min:1|max:2', nope()->numeric(1, 2)->toString());
        self::assertEquals('string|min:1|max:2', nope()->string(1, 2)->toString());

        self::assertEquals('active_url|max:30', nope()->activeUrl(30)->toString());
        self::assertEquals('file|max:30', nope()->file(30)->toString());
        self::assertEquals('image|max:30', nope()->image(30)->toString());
        self::assertEquals('json|max:30', nope()->json(30)->toString());
        self::assertEquals('url|max:30', nope()->url(30)->toString());
    }

    public function testStringCustomRules()
    {
        self::assertEquals('string|max:30', nope()->stringOf(30)->toString());
    }

    public function testUndefinedRule()
    {
        self::assertEquals("my_custom_extended_rule:1,2,3,4", nope()->myCustomExtendedRule(1, 2, 3, 4)->toString());
    }

}
