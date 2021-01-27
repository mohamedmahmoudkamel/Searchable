<?php


use PHPUnit\Framework\TestCase;
use MKamel\Searchable\Exceptions\NotFoundFilterException;

class SearchableTest extends TestCase
{
    protected function setUp(): void
    {
        $this->mock = $this->getMockForTrait('MKamel\Searchable\Traits\Searchable');
    }


    /** @test */
    public function it_should_throw_exception_if_filter_does_not_exist()
    {
        $this->expectException(NotFoundFilterException::class);

        $getFilterReflection = new ReflectionMethod(
            get_class($this->mock),
            'getFilter'
        );

        $getFilterReflection->setAccessible(true);

        $getFilterReflection->invokeArgs($this->mock, ['name']);
    }


    /** @test */
    public function it_should_return_default_namespace()
    {
        $getNameSpaceReflection = new ReflectionMethod(
            get_class($this->mock),
            'getNameSpace'
        );

        $getNameSpaceReflection->setAccessible(true);

        $namespace = $getNameSpaceReflection->invokeArgs($this->mock, []);

        $this->assertEquals('ACME\Filters', $namespace);
    }


    /** @test */
    public function it_should_return_filter_name()
    {
        $filters = [
            'name' => 'ByNameFilter',
            'user_id' => 'ByUserIdFilter',
            'payment_type_id' => 'ByPaymentTypeIdFilter',
        ];

        $getFilterNameReflection = new ReflectionMethod(
            get_class($this->mock),
            'getFilterName'
        );

        $getFilterNameReflection->setAccessible(true);

        foreach ($filters as $key => $value) {
            $filterName = $getFilterNameReflection->invokeArgs($this->mock, [$key]);
            $this->assertEquals($value, $filterName);
        }

    }
}
