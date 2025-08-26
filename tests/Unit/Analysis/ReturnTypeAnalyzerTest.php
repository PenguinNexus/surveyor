<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\StaticAnalyzer\Types\ClassType;
use Laravel\StaticAnalyzer\Types\Entities\View;
use Laravel\StaticAnalyzer\Types\StringType;
use Laravel\StaticAnalyzer\Types\UnionType;

describe('ReturnTypeAnalyzer', function () {
    it('analyzes method with declared return type', function () {
        $result = analyzeFile('app/Http/Controllers/UserController.php');

        $methodReturnTypes = $result->methodReturnType(UserController::class, 'index');

        $this->assertCount(2, $methodReturnTypes);
        $this->assertInstanceOf(View::class, $methodReturnTypes[0]);
        $this->assertEquals('users.empty', $methodReturnTypes[0]->name);
        $this->assertInstanceOf(ClassType::class, $methodReturnTypes[0]->data['users']);
        $this->assertEquals(LengthAwarePaginator::class, $methodReturnTypes[0]->data['users']->value);
        $this->assertArrayHasKey('whatever', $methodReturnTypes[0]->data);
        $this->assertInstanceOf(StringType::class, $methodReturnTypes[0]->data['whatever']);
        $this->assertEquals('third', $methodReturnTypes[0]->data['whatever']->value);

        $this->assertInstanceOf(View::class, $methodReturnTypes[1]);
        $this->assertEquals('users.index', $methodReturnTypes[1]->name);
        $this->assertInstanceOf(ClassType::class, $methodReturnTypes[1]->data['users']);
        $this->assertEquals(LengthAwarePaginator::class, $methodReturnTypes[1]->data['users']->value);
        $this->assertArrayHasKey('whatever', $methodReturnTypes[1]->data);
        $this->assertInstanceOf(UnionType::class, $methodReturnTypes[1]->data['whatever']);
        $this->assertCount(3, $methodReturnTypes[1]->data['whatever']->types);
        $this->assertInstanceOf(StringType::class, $methodReturnTypes[1]->data['whatever']->types[0]);
        $this->assertInstanceOf(StringType::class, $methodReturnTypes[1]->data['whatever']->types[1]);
        $this->assertInstanceOf(StringType::class, $methodReturnTypes[1]->data['whatever']->types[2]);
        $this->assertEquals('first', $methodReturnTypes[1]->data['whatever']->types[0]->value);
        $this->assertEquals('second', $methodReturnTypes[1]->data['whatever']->types[1]->value);
        $this->assertEquals('fourth', $methodReturnTypes[1]->data['whatever']->types[2]->value);
    });
});
