# TEST: Cost effective delivery

Task is the last section.

## Usage

For demo version just edit and run `Test.php` after `composer dump-autoload`. Output is a `Warehouse` object, which is closest to buyer. Current version Buyer's city is Budapest and there are some Hungarian cities defined, but you can set `$randomPoints` to `true` in Test class, so it would generate random coordinates and names for them.

For live version call function with `new App($buyer, $order, $warehouses);` command.

---

## Example output

Closest Warehouse and calculated shipping price.

```php
App\Model\Warehouse Object
(
    [latitude:App\Model\AbstractPosition:private] => 47.35133
    [longitude:App\Model\AbstractPosition:private] => 19.44733
    [id:App\Model\Warehouse:private] => Monor
    [itemStock:App\Model\Warehouse:private] => 4
)

3516.5926421627
```

## Task

Dóri would like to order 10 "Bride Squad" T-shirts for her girlfriend's upcoming bachelorette party.

She decided to send her order via the tshirts.tld website and entered a coordinate as the delivery address. 

tshirts.tld has 3 warehouses, and each warehouse has it's own T-Shirt stock and unique coordinate.

Goal:

Finding the most cost effective transport route by the combination of the warehouses for tshirts.tld.

Rule:

* In case of transport between Dóri's delivery address and a warehouse, 100% of cost is calculated.
* In case of transport between warehouses, only 15% cost is calculated.
* Dóri must meet only with one courier.

Additional info

* There are many ways to solve the problem! Try to implement a business realistic model.
* Use PHP programming language.
* Do not use any persistent storage. Store everything you need in memory.
* You can use any third-party library.
* Do not use any third-party services.
* Do not implement the user interface.
* Do not write a pseudo code. Write a code that you would commit/push to a repository and which solves the given problem.

Bonus – Not mandatory

* Including Unit tests is a plus.
