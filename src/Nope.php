<?php /** @noinspection DuplicatedCode */

namespace Amirhs712\RuleBuilder;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Dimensions;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\NotIn;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\Rules\Unique;
use RuntimeException;

/**
 * Class Nope
 * @package Amirhs712\RuleBuilder
 * @method $this accepted() The field under validation must be yes, on, 1, or true. This is useful for validating "Terms of Service" acceptance.
 * @method $this activeUrl($max = null) The field under validation must have a valid A or AAAA record according to the dns_get_record PHP function. The hostname of the provided URL is extracted using the parse_url PHP function before being passed to dns_get_record.
 * @method $this after(string|Carbon $date) The field under validation must be a value after a given date. The dates will be passed into the strtotime PHP function:
 * @method $this afterOrEqual(string|Carbon $date) The field under validation must be a value after or equal to the given date. For more information, see the after rule.
 * @method $this alpha($min = null, $max = null) The field under validation must be entirely alphabetic characters.
 * @method $this alphaDash($min = null, $max = null) The field under validation may have alpha-numeric characters, as well as dashes and underscores.
 * @method $this alphaNum($min = null, $max = null) The field under validation must be entirely alpha-numeric characters.
 * @method $this array($min = null, $max = null) The field under validation must be a PHP array.
 * @method $this bail() Stop running validation rules after the first validation failure.
 * @method $this before(string|Carbon $date) The field under validation must be a value preceding the given date. The dates will be passed into the PHP strtotime function. In addition, like the after rule, the name of another field under validation may be supplied as the value of date.
 * @method $this beforeOrEqual(string|Carbon $date)
 * @method $this between($min, $max) The field under validation must have a size between the given min and max. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
 * @method $this boolean() The field under validation must be able to be cast as a boolean. Accepted input are true, false, 1, 0, "1", and "0".
 * @method $this confirmed() The field under validation must have a matching field of foo_confirmation. For example, if the field under validation is password, a matching password_confirmation field must be present in the input.
 * @method $this date() The field under validation must be a valid, non-relative date according to the strtotime PHP function.
 * @method $this dateEquals(string|Carbon $date) The field under validation must be equal to the given date. The dates will be passed into the PHP strtotime function.
 * @method $this dateFormat($date) The field under validation must match the given format. You should use either date or date_format when validating a field, not both. This validation rule supports all formats supported by PHP's DateTime class.
 * @method $this different($field) The field under validation must have a different value than field.
 * @method $this digits($value) The field under validation must be numeric and must have an exact length of value.
 * @method $this digitsBetween($min, $max) The field under validation must be numeric and must have a length between the given min and max.
 * @method $this dimensions(Dimensions|array $dimensions) The file under validation must be an image meeting the dimension constraints as specified. Available constraints: [min_width, max_width, min_height, max_height, width, height, ratio]. e.g: dimensions(['min_height' => 100])
 * @method $this distinct() When working with arrays, the field under validation must not have any duplicate values.
 * @method $this email($validator = 'RFCValidation') The field under validation must be formatted as an e-mail address. Available validation styles: [rfc, strict, dns, spoof, filter]
 * @method $this endsWith($arguments) The field under validation must end with one of the given values.
 * @method $this exists($table, $column = null) The field under validation must exist on a given database table. For more information visit the laravel documentation.
 * @method $this excludeIf($anotherField, $value) The field under validation will be excluded from the request data returned by the validate and validated methods if the anotherfield field is equal to value.
 * @method $this excludeUnless($anotherField, $value) The field under validation will be excluded from the request data returned by the validate and validated methods unless anotherfield's field is equal to value.
 * @method $this file($max = null) The field under validation must be a successfully uploaded file.
 * @method $this filled() The field under validation must not be empty when it is present.
 * @method $this gt($field) The field under validation must be greater than the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
 * @method $this gte($field) The field under validation must be greater than or equal to the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
 * @method $this image($max = null) The file under validation must be an image (jpeg, png, bmp, gif, svg, or webp)
 * @method $this in(array|In $value) The field under validation must be included in the given list of values.
 * @method $this notIn(array|NotIn $value) The field under validation must not be included in the given list of values.
 * @method $this inArray($anotherField) The field under validation must exist in anotherfield's values.
 * @method $this integer($min = null, $max = null) The field under validation must be an integer. This validation rule does not verify that the input is of the "integer" variable type, only that the input is a string or numeric value that contains an integer.
 * @method $this ip() The field under validation must be an IP address.
 * @method $this ipv4() The field under validation must be an IPv4 address.
 * @method $this ipv6() The field under validation must be an IPv6 address.
 * @method $this json($max = null) The field under validation must be a valid JSON string.
 * @method $this lt($field) The field under validation must be less than the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
 * @method $this lte($field) The field under validation must be less than or equal to the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
 * @method $this max($value) The field under validation must be less than or equal to a maximum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
 * @method $this mimetypes($mimetypes) The file under validation must match one of the given MIME types. To determine the MIME type of the uploaded file, the file's contents will be read and the framework will attempt to guess the MIME type, which may be different from the client provided MIME type.
 * @method $this mimes($mimes) The file under validation must have a MIME type corresponding to one of the listed extensions.
 * @method $this min($value) The field under validation must have a minimum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
 * @method $this notRegex($pattern) The field under validation must not match the given regular expression. Internally, this rule uses the PHP preg_match function. The pattern specified should obey the same formatting required by preg_match and thus also include valid delimiters. Note: When using the regex / not_regex patterns, it may be necessary to specify rules in an array instead of using pipe delimiters, especially if the regular expression contains a pipe character.
 * @method $this nullable() The field under validation may be null. This is particularly useful when validating primitive such as strings and integers that can contain null values.
 * @method $this numeric($min = null, $max = null) The field under validation must be numeric.
 * @method $this password($guard = null) The field under validation must match the authenticated user's password. You may specify an authentication guard using the rule's first parameter.
 * @method $this present() The field under validation must be present in the input data but can be empty.
 * @method $this raw(string|\Illuminate\Contracts\Validation\Rule $rule) Add raw validation rules.
 * @method $this regex($pattern) The field under validation must match the given regular expression. Note: When using the regex / not_regex patterns, it may be necessary to specify rules in an array instead of using pipe delimiters, especially if the regular expression contains a pipe character.
 * @method $this required() The field under validation must be present in the input data and not empty. A field is considered "empty" if: [The value is null, The value is an empty string, The value is an empty array or empty Countable object, The value is an uploaded file with no path.]
 * @method $this requiredIf(boolean|callback|RequiredIf|string $anotherField, $value = null) The field under validation must be present and not empty if the anotherfield field is equal to any value. You can pass a callback ( or a boolean) or RequiredIf object to the first argument (second argument will be ignored).
 * @method $this requiredUnless($anotherField, $values) The field under validation must be present and not empty unless the anotherfield field is equal to any value.
 * @method $this requiredWith($anotherField, $values) The field under validation must be present and not empty only if any of the other specified fields are present.
 * @method $this requiredWithAll($anotherField, $values) The field under validation must be present and not empty only if all of the other specified fields are present.
 * @method $this requiredWithout($anotherField, $values) The field under validation must be present and not empty only when any of the other specified fields are not present.
 * @method $this requiredWithoutAll($anotherField, $values) The field under validation must be present and not empty only when all of the other specified fields are not present.
 * @method $this same($field) The given field must match the field under validation.
 * @method $this size($value) The field under validation must have a size matching the given value. For string data, value corresponds to the number of characters. For numeric data, value corresponds to a given integer value (the attribute must also have the numeric or integer rule). For an array, size corresponds to the count of the array. For files, size corresponds to the file size in kilobytes.
 * @method $this sometimes()
 * @method $this startsWith() The field under validation must start with one of the given values.
 * @method $this string($min = null, $max = null) The field under validation must be a string. If you would like to allow the field to also be null, you should assign the nullable rule to the field.
 * @method $this timezone() The field under validation must be a valid timezone identifier according to the timezone_identifiers_list PHP function.
 * @method $this unique($table, $column = null) The field under validation must not exist within the given database table.
 * @method $this url($min = null, $max = null) The field under validation must be a valid URL.
 * @method $this uuid() The field under validation must be a valid RFC 4122 (version 1, 3, 4, or 5) universally unique identifier (UUID).
 * @method $this when(bool|callable $condition, callable $callback) Add rules conditionally.
 * @method $this stringOf($max) The field under validation must be a string of $max characters.
 */
class Nope
{
    //TODO: Add protected rule to throw an exception in case of undefined method is called inside of __call (custom validation rules must be handled)

    protected $appliedRules = [];
    protected $proxyRules = [
        'in' => In::class,
        'notIn' => NotIn::class,
        'dimensions' => Dimensions::class,
        'exists' => Exists::class,
        'unique' => Unique::class
    ];

    protected $minMaxRules = [
        'alpha',
        'alphaDash',
        'alphaNum',
        'array',
        'integer',
        'numeric',
        'string',

        //Only max rules
        'activeUrl',
        'file',
        'image',
        'json',
        'url',
    ];

    protected $maxRules = [
        'activeUrl',
        'file',
        'image',
        'json',
        'url',
    ];

    public static function __callStatic($method, $arguments)
    {
        return (new self())->$method(...$arguments);
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this, $localMethod = $method . 'Handler')) {
            $this->$localMethod(...$arguments);
            return $this;
        }

        if (isset($this->proxyRules[$method])) {
            $this->handleProxyRule($method, $arguments);
            return $this;
        }

        if (in_array($method, $this->minMaxRules, true)) {
            $this->handleMinMaxRule($method, ...$arguments);
            return $this;
        }

        $this->apply(Str::snake($method), $this->buildStringArgument($arguments));


        return $this;
    }

    protected function apply($name, $arguments = null)
    {
        $this->appliedRules[] = [
            'name' => $name,
            'arguments' => $arguments
        ];
    }

    protected function applyProxyRule($value)
    {
        $this->apply(null, $value);
    }

    protected function handleProxyRule($method, $arguments)
    {
        if ($arguments == null) {
            throw new RuntimeException("0 arguments passed to '$method' rule.");
        }

        $class = $this->proxyRules[$method];

        if (isset($arguments[0]) && $arguments[0] instanceof $class) {
            $this->applyProxyRule(...$arguments);
        } else {
            $this->applyProxyRule(Rule::$method(...$arguments));
        }
    }

    protected function handleMinMaxRule($method, $first = null, $second = null)
    {
        //Apply the rule without arguments
        $this->apply(Str::snake($method));

        if (in_array($method, $this->maxRules, true)) {
            //This rule only supports maximum, so the first argument is considered as our max.
            $this->max($first);
        } else {
            //This rule supports both minimum and maximum.
            if ($first) {
                $this->min($first);
            }

            if ($second) {
                $this->max($second);
            }
        }
    }

    /**
     * @param $rules
     * @return array|false|string[]
     */
    protected function ensureIsArray($rules)
    {
        if (is_string($rules)) {
            return explode('|', $rules);
        }

        return is_array($rules) ? $rules : [$rules];
    }

    protected function buildStringArgument(array $arguments)
    {
        if ($arguments) {
            return implode(',', Arr::flatten($arguments));
        }
    }

    private function handleRequiredOption($required)
    {
        if ($required === 1) {
            $this->required();
        }

        if ($required < 0) {
            $this->sometimes();
        }

        if ($required === -2) {
            $this->nullable();
        }
    }

    /**
     * Returns the result as string.
     *
     *<p>Call toArray method if you have a validation object.</p>
     * <p>If $required = 1 => Add required rule and return the result.</p>
     * <p>If $required = 0 => Just return the result.</p>
     * <p>If $required = -1 => Add sometimes rule and return the result.</p>
     * <p>If $required = -2 => Add sometimes|nullable rules and return the result.</p>
     * @param int $required
     * @return string
     */
    public function toString($required = 0)
    {
        $this->handleRequiredOption($required);
        return (string)$this;
    }

    public function dd()
    {
        dd($this->__toString());
    }

    /**
     * Returns the result as array.
     *
     * <p>Use this method to return all the rules as array, also when you have validation objects, you MUST call this function instead of get.</p>
     * <p>Call toArray method if you have a validation object.</p>
     * <p>If $required = 1 => Add required rule and return the result.</p>
     * <p>If $required = 0 => Just return the result.</p>
     * <p>If $required = -1 => Add sometimes rule and return the result.</p>
     * <p>If $required = -2 => Add sometimes|nullable rules and return the result.</p>
     * @param int $required
     * @return array
     */
    public function get($required = 0)
    {
        $this->handleRequiredOption($required);
        return $this->parseRules(new ArrayParser());
    }

    private function parseRules(Parser $parser)
    {
        $rules = [];
        foreach ($this->appliedRules as $appliedRule) {
            $rules[] = $parser->parse($appliedRule['name'], $appliedRule['arguments']);
        }

        return $rules;
    }

    public function __toString()
    {
        $rules = $this->parseRules(new StringParser());

        return implode('|', $rules);
    }

    //----------------------------------- Custom handlers -----------------------------------------------------------\\
    protected function requiredIfHandler($firstArgument, $secondArgument = null)
    {
        if ($firstArgument === true) {
            $this->required();
        } else if ($firstArgument instanceof RequiredIf) {
            $this->applyProxyRule($firstArgument);
        } else if (is_callable($firstArgument)) {
            $this->applyProxyRule(new RequiredIf($firstArgument));
        } else {
            $this->apply('requiredIf', $this->buildStringArgument([$firstArgument, $secondArgument]));
        }
    }

    protected function rawHandler($rules)
    {
        foreach ($this->ensureIsArray($rules) as $rule) {
            $this->applyProxyRule($rule);
        }
    }

    protected function whenHandler($condition, $callback)
    {
        $condition = is_callable($condition) ? $condition() : $condition;
        if ($condition) {
            $callback($condition);
        }
    }

    protected function stringOfHandler($max)
    {
        $this->string(null, $max);
    }

    //--- Custom date handlers
    protected function applyCarbonRule($name, $value)
    {
        $value = $value instanceof Carbon ? $value->toIso8601String() : $value;
        $this->apply($name, $value);
    }

    protected function dateEqualsHandler($value)
    {
        $this->applyCarbonRule('date_equals', $value);
    }

    protected function afterHandler($value)
    {
        $this->applyCarbonRule('after', $value);
    }

    protected function afterOrEqualHandler($value)
    {
        $this->applyCarbonRule('after_or_equal', $value);
    }

    protected function beforeHandler($value)
    {
        $this->applyCarbonRule('before', $value);
    }

    protected function beforeOrEqualHandler($value)
    {
        $this->applyCarbonRule('before_or_equal', $value);
    }
}
