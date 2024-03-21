<?php

declare(strict_types=1);

namespace Wwwision\BenchmarkTest\Benchmarks;

use PhpBench\Benchmark\Metadata\Annotations\ParamProviders;

/**
 * @BeforeMethods("setUp")
 */
class HashingBench
{
    /**
     * @var string
     */
    private $string = '';

    public function setUp(array $params): void
    {
        $this->string = str_repeat('X', $params['size']);
    }

    /**
     * @ParamProviders({
     *     "provideAlgos",
     *     "provideStringSize"
     * })
     */
    public function benchAlgos($params): void
    {
        /** @noinspection PhpExpressionResultUnusedInspection */
        hash($params['algo'], $this->string);
    }

    public function provideAlgos()
    {
        foreach (array_slice(\hash_algos(), 0, 5) as $algo) {
            if ($algo === 'md2') { // md2 is in a different performance category
                continue;
            }
            yield ['algo' => $algo];
        }

    }

    public function provideStringSize() {
        yield ['size' => 10];
        yield ['size' => 100];
        #yield ['size' => 1000];
    }

}