
/**
 * This file is part of the Phalcon.
 *
 * (c) Phalcon Team <team@phalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phalcon\Helper;

use Phalcon\Helper\Exception;

/**
 * Phalcon\Helper\Arr
 *
 * This class offers quick array functions throught the framework
 */
class Arr
{
    /**
     * Chunks an array into smaller arrays of a specified size.
     */
    final public static function chunk(array! collection, int size, bool preserveKeys = false) -> array
    {
        return array_chunk(collection, size, preserveKeys);
    }

    /**
     * Returns the first element of the collection. If a callable is passed, the
     * element returned is the first that validates true
     *
     * @param callable $method
     */
    final public static function first(array! collection, var method = null) -> var
    {
        var filtered;

        let filtered = self::filterCollection(collection, method);

        return reset(filtered);
    }

    /**
     * Returns the key of the first element of the collection. If a callable
     * is passed, the element returned is the first that validates true
     *
     * @param callable $method
     */
    final public static function firstKey(array! collection, var method = null) -> var
    {
        var filtered;

        if null !== method && is_callable(method)  {
            let filtered = array_filter(collection, method);
        } else {
            let filtered = collection;
        }

        reset(filtered);

        return key(filtered);
    }

    /**
     * Flattens an array up to the one level depth, unless `$deep` is set to `true`
     */
    final public static function flatten(array! collection, bool deep = false) -> array
    {
        var data, item;

        let data = [];
        for item in collection {
            if typeof item !== "array" {
                let data[] = item;
            } else {
                if deep {
                    let data = array_merge(data, self::flatten(item, true));
                } else {
                    let data = array_merge(data, array_values(item));
                }
            }
        }

        return data;
    }

    /**
     * Helper method to get an array element or a default
     */
    final public static function get(array! collection, var index, var defaultValue) -> var
    {
        var value;

        if likely fetch value, collection[index] {
            return value;
        }

        return defaultValue;
    }

    /**
     * Groups the elements of an array based on the passed callable
     *
     * @param callable $method
     */
    final public static function group(array! collection, var method) -> array
    {
        var element, key;
        array filtered;

        let filtered = [];
        for element in collection {
            if (typeof method !== "string" && is_callable(method)) || function_exists(method) {
                let key             = call_user_func(method, element),
                    filtered[key][] = element;
            } elseif typeof element === "object" {
                let key             = element->{method},
                    filtered[key][] = element;
            } elseif isset element[method] {
                let key             = element[method],
                    filtered[key][] = element;
            }
        }

        return filtered;
    }

    /**
     * Helper method to get an array element or a default
     */
    final public static function has(array! collection, var index) -> bool
    {
        return isset collection[index];
    }

    /**
     * Checks a flat list for duplicate values. Returns true if duplicate
     * values exist and false if values are all unique.
     */
    final public static function isUnique(array! collection) -> bool
    {
        return count(collection) === count(array_unique(collection));
    }

    /**
     * Returns the last element of the collection. If a callable is passed, the
     * element returned is the first that validates true
     *
     * @param callable $method
     */
    final public static function last(array! collection, var method = null) -> var
    {
        var filtered;

        if null !== method && is_callable(method)  {
            let filtered = array_filter(collection, method);
        } else {
            let filtered = collection;
        }

        return end(filtered);
    }

    /**
     * Returns the key of the last element of the collection. If a callable is
     * passed, the element returned is the first that validates true
     *
     * @param callable $method
     */
    final public static function lastKey(array! collection, var method = null) -> var
    {
        var filtered;

        if null !== method && is_callable(method)  {
            let filtered = array_filter(collection, method);
        } else {
            let filtered = collection;
        }

        end(filtered);

        return key(filtered);
    }

    /**
     * Sorts a collection of arrays or objects by key
     */
    final public static function order(array! collection, var attribute, string order = "asc") -> array
    {
        var item, key;
        array sorted;

        let sorted = [];

        for item in collection {
            if typeof item === "object" {
                let key = item->{attribute};
            } else {
                let key = item[attribute];
            }

            let sorted[key] = item;
        }

        if order === "asc" {
            ksort(sorted);
        } else {
            krsort(sorted);
        }

        return array_values(sorted);
    }

    /**
     * Retrieves all of the values for a given key.
     */
    final public static function pluck(array! collection, string element) -> array
    {
        var item;
        array filtered;

        let filtered = [];

        for item in collection {
            if typeof item === "object" && isset item->{element} {
                let filtered[] = item->{element};
            } elseif typeof item === "array" && isset item[element] {
                let filtered[] = item[element];
            }
        }

        return filtered;
    }

    /**
     * Helper method to set an array element
     */
    final public static function set(array! collection, var value, var index = null) -> array
    {
        if null === index {
            let collection[] = value;
        } else {
            let collection[index] = value;
        }

        return collection;
    }

    /**
     * Returns a new array with n elements removed from the right.
     */
    final public static function sliceLeft(array! collection, int elements = 1) -> array
    {
        return array_slice(collection, 0, elements);
    }

    /**
     * Returns a new array with the X elements from the right
     */
    final public static function sliceRight(array! collection, int elements = 1) -> array
    {
        return array_slice(collection, elements);
    }

    /**
     * Returns a new array with keys of the passed array as one element and
     * values as another
     */
    final public static function split(array! collection) -> array
    {
        return [
            array_keys(collection),
            array_values(collection)
        ];
    }

    /**
     * Returns true if the provided function returns true for all elements of
     * the collection, false otherwise.
     *
     * @param callable $method
     */
    final public static function validateAll(array! collection, var method) -> bool
    {
        return count(array_filter(collection, method)) === count(collection);
    }

    /**
     * Returns true if the provided function returns true for at least one
     * element fo the collection, false otherwise.
     *
     * @param callable $method
     */
    final public static function validateAny(array! collection, var method) -> bool
    {
        return count(array_filter(collection, method)) > 0;
    }

    final private static function filterCollection(array collection, var method = null) -> array
    {
        if null !== method && is_callable(method)  {
            return array_filter(collection, method);
        } else {
            return collection;
        }
    }
}