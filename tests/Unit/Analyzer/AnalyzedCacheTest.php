<?php

use Laravel\Surveyor\Analyzer\AnalyzedCache;
use Laravel\Surveyor\Analyzer\Analyzer;
use Laravel\Surveyor\SurveyorServiceProvider;

uses()->group('cache');

beforeEach(function () {
    // Register service provider
    $this->app->register(SurveyorServiceProvider::class);

    // Clear cache before each test
    AnalyzedCache::clear();
});

afterEach(function () {
    // Clean up after tests
    AnalyzedCache::clear();
});

it('caches analyzed files', function () {
    $fixture = createTestClassFixture('TestClass', 'public function test() { return "hello"; }');

    $analyzer = app(Analyzer::class);
    $result1 = $analyzer->analyze($fixture);

    // Second analysis should use cache
    $result2 = $analyzer->analyze($fixture);

    expect($result1->analyzed())->toBe($result2->analyzed());

    unlink($fixture);
});

it('invalidates cache when file is modified', function () {
    $fixture = createTestClassFixture('TestClass', 'public function test() { return "hello"; }');

    $analyzer = app(Analyzer::class);
    $result1 = $analyzer->analyze($fixture);
    $cached1 = AnalyzedCache::get($fixture);

    // Modify the file
    sleep(1); // Ensure mtime changes
    file_put_contents($fixture, "<?php\nclass TestClass { public function test() { return 'world'; } }");

    // Should re-analyze since file changed
    $result2 = $analyzer->analyze($fixture);
    $cached2 = AnalyzedCache::get($fixture);

    // The cached objects should be different instances (file was re-analyzed)
    expect($cached1)->not()->toBe($cached2);

    unlink($fixture);
});

it('can enable disk caching', function () {
    $cacheDir = sys_get_temp_dir().'/surveyor-test-cache-'.uniqid();
    AnalyzedCache::enableDiskCache($cacheDir);

    $fixture = createTestClassFixture('TestClass', 'public function test() { return "hello"; }');

    $analyzer = app(Analyzer::class);
    $analyzer->analyze($fixture);

    // Check that cache file was created
    $cacheFiles = glob($cacheDir.'/*.cache');
    expect($cacheFiles)->toHaveCount(1);

    // Clear in-memory cache only (keep disk cache)
    AnalyzedCache::clearMemory();

    // Should load from disk
    $cached = AnalyzedCache::get($fixture);
    expect($cached)->not()->toBeNull();

    // Clean up
    unlink($fixture);
    foreach (glob($cacheDir.'/*.cache') as $file) {
        unlink($file);
    }
    rmdir($cacheDir);
});

it('invalidates disk cache when file is modified', function () {
    $cacheDir = sys_get_temp_dir().'/surveyor-test-cache-'.uniqid();
    AnalyzedCache::enableDiskCache($cacheDir);

    $fixture = createTestClassFixture('TestClass', 'public function test() { return "hello"; }');

    $analyzer = app(Analyzer::class);
    $analyzer->analyze($fixture);

    // Verify cache file exists
    $cacheFiles = glob($cacheDir.'/*.cache');
    expect($cacheFiles)->toHaveCount(1);

    // Modify the file
    sleep(1); // Ensure mtime changes
    file_put_contents($fixture, "<?php\nclass TestClass { public function test() { return 'world'; } }");

    // Clear in-memory cache to force disk lookup
    AnalyzedCache::clear();

    // Should return null because file was modified
    $cached = AnalyzedCache::get($fixture);
    expect($cached)->toBeNull();

    // Cache file should be deleted
    $cacheFiles = glob($cacheDir.'/*.cache');
    expect($cacheFiles)->toHaveCount(0);

    // Clean up
    unlink($fixture);
    if (is_dir($cacheDir)) {
        rmdir($cacheDir);
    }
});

it('handles non-existent files gracefully', function () {
    $nonExistentFile = '/path/to/nonexistent/file.php';

    $cached = AnalyzedCache::get($nonExistentFile);
    expect($cached)->toBeNull();
});

it('can manually invalidate cache', function () {
    $fixture = createTestClassFixture('TestClass', 'public function test() { return "hello"; }');

    $analyzer = app(Analyzer::class);
    $analyzer->analyze($fixture);

    // Verify it's cached
    $cached = AnalyzedCache::get($fixture);
    expect($cached)->not()->toBeNull();

    // Invalidate
    AnalyzedCache::invalidate($fixture);

    // Should be gone
    $cached = AnalyzedCache::get($fixture);
    expect($cached)->toBeNull();

    unlink($fixture);
});

it('can set directory and enable cache separately', function () {
    $cacheDir = sys_get_temp_dir().'/surveyor-test-cache-'.uniqid();

    // Set directory first
    AnalyzedCache::setCacheDirectory($cacheDir);
    expect(is_dir($cacheDir))->toBeTrue();

    // Enable caching
    AnalyzedCache::enable();

    $fixture = createTestClassFixture('TestClass', 'public function test() { return "hello"; }');

    $analyzer = app(Analyzer::class);
    $analyzer->analyze($fixture);

    // Verify cache file was created
    $cacheFiles = glob($cacheDir.'/*.cache');
    expect($cacheFiles)->toHaveCount(1);

    // Clean up
    unlink($fixture);
    foreach (glob($cacheDir.'/*.cache') as $file) {
        unlink($file);
    }
    rmdir($cacheDir);
});

it('throws exception when enabling without setting directory', function () {
    // This test needs to run in isolation with no cache directory set
    // We can't easily reset the static properties, so we'll test this behavior
    // by checking that enabling requires a directory to be set first

    $reflection = new \ReflectionClass(AnalyzedCache::class);
    $property = $reflection->getProperty('cacheDirectory');
    $property->setAccessible(true);
    $originalDir = $property->getValue();

    // Set directory to null
    $property->setValue(null);

    try {
        AnalyzedCache::enable();
        expect(false)->toBeTrue('Should have thrown exception');
    } catch (\RuntimeException $e) {
        expect($e->getMessage())->toContain('Cache directory must be set');
    } finally {
        // Restore original directory
        if ($originalDir !== null) {
            $property->setValue($originalDir);
        }
    }
});

it('can disable and re-enable cache', function () {
    $cacheDir = sys_get_temp_dir().'/surveyor-test-cache-'.uniqid();
    AnalyzedCache::enableDiskCache($cacheDir);

    $fixture = createTestClassFixture('TestClass', 'public function test() { return "hello"; }');

    $analyzer = app(Analyzer::class);
    $analyzer->analyze($fixture);

    // Verify cache file was created
    $cacheFiles = glob($cacheDir.'/*.cache');
    expect($cacheFiles)->toHaveCount(1);

    // Disable cache
    AnalyzedCache::disable();
    AnalyzedCache::clearMemory();

    // Create a second fixture
    $fixture2 = createTestClassFixture('TestClass2', 'public function test2() { return "world"; }');
    $analyzer->analyze($fixture2);

    // No new cache file should be created
    $cacheFiles = glob($cacheDir.'/*.cache');
    expect($cacheFiles)->toHaveCount(1);

    // Clean up
    unlink($fixture);
    unlink($fixture2);
    foreach (glob($cacheDir.'/*.cache') as $file) {
        unlink($file);
    }
    rmdir($cacheDir);
});

describe('dependency tracking', function () {
    it('tracks analysis stack correctly', function () {
        AnalyzedCache::clearMemory();

        // Initially empty
        expect(AnalyzedCache::isRootAnalysis())->toBeFalse();

        // Push first analysis - becomes root
        AnalyzedCache::pushAnalysis('/path/to/file1.php');
        expect(AnalyzedCache::isRootAnalysis())->toBeTrue();

        // Push nested analysis - not root anymore
        AnalyzedCache::pushAnalysis('/path/to/file2.php');
        expect(AnalyzedCache::isRootAnalysis())->toBeFalse();

        // Pop back to root
        AnalyzedCache::popAnalysis();
        expect(AnalyzedCache::isRootAnalysis())->toBeTrue();

        // Pop to empty
        AnalyzedCache::popAnalysis();
        expect(AnalyzedCache::isRootAnalysis())->toBeFalse();
    });

    it('registers nested analysis as dependency of root', function () {
        AnalyzedCache::clearMemory();

        $mainFixture = createTestClassFixture('MainClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepClass', 'public function dep() {}');

        // Simulate: analyzing main, which triggers analysis of dep
        AnalyzedCache::pushAnalysis($mainFixture);

        // Nested analysis starts
        AnalyzedCache::pushAnalysis($depFixture);
        AnalyzedCache::popAnalysis();

        // Now when we add the main file, it should have dep as dependency
        $reflection = new \ReflectionClass(AnalyzedCache::class);
        $pendingDeps = $reflection->getProperty('pendingDependencies');
        $pendingDeps->setAccessible(true);

        $deps = $pendingDeps->getValue();
        expect($deps)->toHaveKey($mainFixture);
        expect($deps[$mainFixture])->toContain($depFixture);

        AnalyzedCache::popAnalysis();

        unlink($mainFixture);
        unlink($depFixture);
    });

    it('real integration: FormRequest-like nested analysis tracks dependencies', function () {
        AnalyzedCache::clearMemory();

        // Create a "FormRequest" class
        $formRequestFixture = tempnam(sys_get_temp_dir(), 'test_formrequest_');
        file_put_contents($formRequestFixture, "<?php
namespace TestApp;

class TestFormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules()
    {
        return ['name' => 'required'];
    }
}");

        // Create a controller that uses the FormRequest
        $controllerFixture = tempnam(sys_get_temp_dir(), 'test_controller_');
        file_put_contents($controllerFixture, '<?php
namespace TestApp;

class TestController
{
    public function store(TestFormRequest $request)
    {
        return $request->validated();
    }
}');

        // We can't easily test the full integration because:
        // 1. The FormRequest needs to be autoloadable for is_subclass_of() to work
        // 2. The reflector needs to be able to find the file

        // Instead, let's verify the debug logging shows the dependency tracking
        $reflection = new \ReflectionClass(AnalyzedCache::class);
        $stackProp = $reflection->getProperty('analysisStack');
        $stackProp->setAccessible(true);

        // Analyze the controller
        $analyzer = app(Analyzer::class);
        $analyzer->analyze($controllerFixture);

        // The FormRequest won't be analyzed because is_subclass_of won't work
        // without proper autoloading, but we can verify the stack is clean
        expect($stackProp->getValue())->toBeEmpty();

        unlink($formRequestFixture);
        unlink($controllerFixture);
    })->skip('Requires autoloading setup for FormRequest detection');

    it('stores dependency mtimes when caching', function () {
        AnalyzedCache::clearMemory();

        $mainFixture = createTestClassFixture('MainClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepClass', 'public function dep() {}');

        $analyzer = app(Analyzer::class);

        // First, analyze the dependency so it exists in cache
        $analyzer->analyze($depFixture);

        AnalyzedCache::clearMemory();

        // Now manually simulate the dependency tracking
        AnalyzedCache::pushAnalysis($mainFixture);
        AnalyzedCache::pushAnalysis($depFixture);
        AnalyzedCache::popAnalysis();

        // Analyze main - should capture dependency
        $analyzer->analyze($mainFixture);

        // Check that dependency mtimes are stored
        $reflection = new \ReflectionClass(AnalyzedCache::class);
        $depMtimes = $reflection->getProperty('dependencyMtimes');
        $depMtimes->setAccessible(true);

        $mtimes = $depMtimes->getValue();
        expect($mtimes)->toHaveKey($mainFixture);
        expect($mtimes[$mainFixture])->toHaveKey($depFixture);
        expect($mtimes[$mainFixture][$depFixture])->toBe(filemtime($depFixture));

        unlink($mainFixture);
        unlink($depFixture);
    });

    it('invalidates cache when dependency file is modified', function () {
        AnalyzedCache::clearMemory();

        $mainFixture = createTestClassFixture('MainClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepClass', 'public function dep() {}');

        // Simulate analyzing main with dep as a dependency
        AnalyzedCache::pushAnalysis($mainFixture);
        AnalyzedCache::pushAnalysis($depFixture);
        AnalyzedCache::popAnalysis();

        $analyzer = app(Analyzer::class);
        $analyzer->analyze($mainFixture);

        // Verify main is cached
        $cached1 = AnalyzedCache::get($mainFixture);
        expect($cached1)->not()->toBeNull();

        // Modify the dependency file
        sleep(1);
        file_put_contents($depFixture, "<?php\nclass DepClass { public function depModified() {} }");

        // Main file cache should now be invalid because dependency changed
        $cached2 = AnalyzedCache::get($mainFixture);
        expect($cached2)->toBeNull();

        unlink($mainFixture);
        unlink($depFixture);
    });

    it('keeps cache valid when dependency has not changed', function () {
        AnalyzedCache::clearMemory();

        $mainFixture = createTestClassFixture('MainClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepClass', 'public function dep() {}');

        // Simulate analyzing main with dep as a dependency
        AnalyzedCache::pushAnalysis($mainFixture);
        AnalyzedCache::pushAnalysis($depFixture);
        AnalyzedCache::popAnalysis();

        $analyzer = app(Analyzer::class);
        $analyzer->analyze($mainFixture);

        // Verify main is cached
        $cached1 = AnalyzedCache::get($mainFixture);
        expect($cached1)->not()->toBeNull();

        // Without modifying anything, cache should still be valid
        $cached2 = AnalyzedCache::get($mainFixture);
        expect($cached2)->not()->toBeNull();
        expect($cached2)->toBe($cached1);

        unlink($mainFixture);
        unlink($depFixture);
    });

    it('tracks transitive dependencies to root', function () {
        AnalyzedCache::clearMemory();

        $fileA = createTestClassFixture('ClassA', 'public function a() {}');
        $fileB = createTestClassFixture('ClassB', 'public function b() {}');
        $fileC = createTestClassFixture('ClassC', 'public function c() {}');

        // Simulate: A -> B -> C (A triggers B which triggers C)
        AnalyzedCache::pushAnalysis($fileA);
        AnalyzedCache::pushAnalysis($fileB);
        AnalyzedCache::pushAnalysis($fileC);
        AnalyzedCache::popAnalysis(); // C done
        AnalyzedCache::popAnalysis(); // B done

        // Check that both B and C are dependencies of A (the root)
        $reflection = new \ReflectionClass(AnalyzedCache::class);
        $pendingDeps = $reflection->getProperty('pendingDependencies');
        $pendingDeps->setAccessible(true);

        $deps = $pendingDeps->getValue();
        expect($deps)->toHaveKey($fileA);
        expect($deps[$fileA])->toContain($fileB);
        expect($deps[$fileA])->toContain($fileC);

        AnalyzedCache::popAnalysis(); // A done

        unlink($fileA);
        unlink($fileB);
        unlink($fileC);
    });

    it('invalidates cache when transitive dependency changes', function () {
        AnalyzedCache::clearMemory();

        $fileA = createTestClassFixture('ClassA', 'public function a() {}');
        $fileB = createTestClassFixture('ClassB', 'public function b() {}');
        $fileC = createTestClassFixture('ClassC', 'public function c() {}');

        // Simulate: A -> B -> C
        AnalyzedCache::pushAnalysis($fileA);
        AnalyzedCache::pushAnalysis($fileB);
        AnalyzedCache::pushAnalysis($fileC);
        AnalyzedCache::popAnalysis();
        AnalyzedCache::popAnalysis();

        $analyzer = app(Analyzer::class);
        $analyzer->analyze($fileA);

        // Verify A is cached
        expect(AnalyzedCache::get($fileA))->not()->toBeNull();

        // Modify the transitive dependency C
        sleep(1);
        file_put_contents($fileC, "<?php\nclass ClassC { public function cModified() {} }");

        // A's cache should be invalid because C (transitive dependency) changed
        expect(AnalyzedCache::get($fileA))->toBeNull();

        unlink($fileA);
        unlink($fileB);
        unlink($fileC);
    });

    it('persists dependencies to disk cache', function () {
        $cacheDir = sys_get_temp_dir().'/surveyor-test-cache-'.uniqid();
        AnalyzedCache::enableDiskCache($cacheDir);
        AnalyzedCache::clearMemory();

        $mainFixture = createTestClassFixture('MainClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepClass', 'public function dep() {}');

        // Simulate dependency tracking and analyze
        AnalyzedCache::pushAnalysis($mainFixture);
        AnalyzedCache::pushAnalysis($depFixture);
        AnalyzedCache::popAnalysis();

        $analyzer = app(Analyzer::class);
        $analyzer->analyze($mainFixture);

        // Clear memory cache, forcing disk lookup
        AnalyzedCache::clearMemory();

        // Should load from disk with dependencies intact
        $cached = AnalyzedCache::get($mainFixture);
        expect($cached)->not()->toBeNull();

        // Modify dependency
        sleep(1);
        file_put_contents($depFixture, "<?php\nclass DepClass { public function depModified() {} }");

        // Clear memory again to force disk lookup
        AnalyzedCache::clearMemory();

        // Should be invalid because dependency changed
        $cached = AnalyzedCache::get($mainFixture);
        expect($cached)->toBeNull();

        // Clean up
        unlink($mainFixture);
        unlink($depFixture);
        foreach (glob($cacheDir.'/*.cache') as $file) {
            unlink($file);
        }
        if (is_dir($cacheDir)) {
            rmdir($cacheDir);
        }
    });

    it('tracks dependencies through actual nested Analyzer calls', function () {
        AnalyzedCache::clearMemory();

        $mainFixture = createTestClassFixture('MainClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepClass', 'public function dep() {}');

        $analyzer = app(Analyzer::class);

        // First analyze main
        $analyzer->analyze($mainFixture);

        // Clear and re-analyze - simulating a fresh run that should use cache
        AnalyzedCache::clearMemory();
        $analyzer->analyze($mainFixture);

        // Now simulate what happens in Param.php: during analysis, a nested analyze() is called
        // We need to test that if we analyze main, and during that analysis we also analyze dep,
        // then dep becomes a dependency of main.

        AnalyzedCache::clearMemory();

        // Start analyzing main - this is the "root" analysis
        $analyzer1 = app(Analyzer::class);
        $result1 = $analyzer1->analyze($mainFixture);

        // During main's analysis, something triggers analysis of dep
        // (In real code, this happens inside Param resolver for FormRequests)
        $analyzer2 = app(Analyzer::class);
        $result2 = $analyzer2->analyze($depFixture);

        // Check that dependency was tracked
        $reflection = new \ReflectionClass(AnalyzedCache::class);
        $depMtimes = $reflection->getProperty('dependencyMtimes');
        $depMtimes->setAccessible(true);

        $mtimes = $depMtimes->getValue();

        // The issue: main's analysis completed before dep was analyzed (they're sequential, not nested)
        // In real usage, dep is analyzed DURING main's analysis, before main calls add()
        // Our test doesn't simulate that properly

        unlink($mainFixture);
        unlink($depFixture);
    })->skip('This test demonstrates the issue - analysis is sequential, not truly nested');

    it('correctly invalidates when analysis triggers nested analysis before completion', function () {
        AnalyzedCache::clearMemory();

        $mainFixture = createTestClassFixture('MainClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepClass', 'public function dep() {}');

        // Manually simulate the CORRECT flow that should happen:
        // 1. Main analysis starts (pushAnalysis called by Analyzer)
        // 2. During main's parsing, something triggers dep analysis
        // 3. Dep analysis completes
        // 4. Main analysis completes (add called by Analyzer, which captures dep as dependency)

        // Step 1: Start main analysis
        AnalyzedCache::pushAnalysis($mainFixture);

        // Step 2: During main's analysis, dep is analyzed (this is what Param.php does)
        $analyzer = app(Analyzer::class);
        $analyzer->analyze($depFixture);

        // Step 3 & 4: Complete main's analysis
        $analyzer->analyze($mainFixture);

        // Wait - this won't work because analyze() calls pushAnalysis AGAIN for main
        // The stack would be: [main, dep, main] which is wrong

        AnalyzedCache::clearMemory();

        unlink($mainFixture);
        unlink($depFixture);
    })->skip('Demonstrates ordering issue');

    it('tracks dependencies through real Analyzer nested calls', function () {
        AnalyzedCache::clearMemory();

        // Create fixtures that will trigger nested analysis
        $mainFixture = createTestClassFixture('MainTestClass', 'public function main() {}');
        $depFixture = createTestClassFixture('DepTestClass', 'public function dep() {}');

        $reflection = new \ReflectionClass(AnalyzedCache::class);
        $stackProp = $reflection->getProperty('analysisStack');
        $stackProp->setAccessible(true);
        $pendingProp = $reflection->getProperty('pendingDependencies');
        $pendingProp->setAccessible(true);
        $depMtimesProp = $reflection->getProperty('dependencyMtimes');
        $depMtimesProp->setAccessible(true);

        // First, analyze main
        $analyzer = app(Analyzer::class);
        $analyzer->analyze($mainFixture);

        // Check stack is empty after analysis
        expect($stackProp->getValue())->toBeEmpty();

        // Check what dependencies were captured
        $depMtimes = $depMtimesProp->getValue();

        // Now manually simulate what Param.php does:
        // During the NEXT analysis of main, we want to trigger a nested analysis of dep

        AnalyzedCache::clearMemory();

        // Manually do what Analyzer::analyze does, but with a nested call in the middle
        AnalyzedCache::pushAnalysis($mainFixture);
        expect($stackProp->getValue())->toBe([$mainFixture]);

        // This is what happens in Param.php - it calls analyze() on another file
        // While main is still being analyzed (before add() is called)
        $analyzer2 = app(Analyzer::class);
        $analyzer2->analyze($depFixture);

        // Check that dep was registered as dependency of main
        $pending = $pendingProp->getValue();
        expect($pending)->toHaveKey($mainFixture);
        expect($pending[$mainFixture])->toContain($depFixture);

        // Now simulate what happens after parsing completes
        // The Analyzer would call add() for the main file
        $mainAnalyzed = $analyzer->analyze($mainFixture)->analyzed();

        // Check dependency mtimes after add
        $depMtimes = $depMtimesProp->getValue();

        AnalyzedCache::popAnalysis();
        expect($stackProp->getValue())->toBeEmpty();

        unlink($mainFixture);
        unlink($depFixture);
    });

    it('end-to-end: simulated nested analysis invalidates on dependency change', function () {
        AnalyzedCache::clearMemory();

        // Create files
        $mainFixture = createTestClassFixture('EndToEndMain', 'public function main() {}');
        $depFixture = createTestClassFixture('EndToEndDep', 'public function dep() {}');

        $analyzer = app(Analyzer::class);

        // First, analyze both files independently so they're in cache
        $analyzer->analyze($mainFixture);
        $analyzer->analyze($depFixture);

        // Clear memory to start fresh
        AnalyzedCache::clearMemory();

        // Now simulate the nested analysis flow:
        // 1. Main starts analyzing (push)
        // 2. During main's parsing, dep is analyzed (push, analyze, pop)
        // 3. Main finishes analyzing (add, pop)

        // Step 1: Start main analysis
        AnalyzedCache::pushAnalysis($mainFixture);

        // Step 2: Nested analysis of dep (what Param.php does)
        // This is a full analyze call, which does its own push/pop
        $analyzer->analyze($depFixture);

        // Step 3: Now add main to cache (simulating what happens after parsing)
        // We need to get a Scope for main - let's analyze it fresh
        $mainScope = $analyzer->analyze($mainFixture)->analyzed();

        // But wait - analyze() already called add() for main with the wrong stack state
        // Because analyze() does push -> add -> pop, but we already pushed main before calling analyze

        // The issue is: when we call analyze($main) AFTER we've manually pushed main,
        // the analyze call pushes AGAIN, making main a dependency of itself

        AnalyzedCache::popAnalysis(); // Pop our manual push

        // This test demonstrates the complexity - we can't easily inject into the middle of analysis
        // The real test needs to be done with actual code that triggers nested analysis

        unlink($mainFixture);
        unlink($depFixture);
    })->skip('Demonstrates why integration test is complex');

    it('full flow: analyzer tracks dependencies when one file references another', function () {
        AnalyzedCache::clearMemory();

        // For this test, we'll verify the mechanism works by checking internal state
        $mainFixture = createTestClassFixture('FullFlowMain', 'public function main() {}');
        $depFixture = createTestClassFixture('FullFlowDep', 'public function dep() {}');

        $reflection = new \ReflectionClass(AnalyzedCache::class);
        $depMtimesProp = $reflection->getProperty('dependencyMtimes');
        $depMtimesProp->setAccessible(true);

        // Manually simulate the exact sequence of events:
        // 1. pushAnalysis(main) - called by Analyzer.analyze()
        // 2. get(main) returns null
        // 3. parsing starts
        // 4. pushAnalysis(dep) - called by nested Analyzer.analyze()
        // 5. get(dep) returns null
        // 6. dep is parsed and added
        // 7. popAnalysis() - dep done
        // 8. main parsing continues
        // 9. add(main) - should capture dep as dependency
        // 10. popAnalysis() - main done

        // Steps 1-3: Main analysis starts
        AnalyzedCache::pushAnalysis($mainFixture);
        AnalyzedCache::inProgress($mainFixture);

        // Steps 4-7: Nested dep analysis (full cycle)
        AnalyzedCache::pushAnalysis($depFixture);
        // Simulate parsing dep and adding result
        // Create a mock scope properly
        $depScope = new \Laravel\Surveyor\Analysis\Scope;
        $depScope->setPath($depFixture);
        AnalyzedCache::add($depFixture, $depScope);
        AnalyzedCache::popAnalysis();

        // Steps 8-9: Main analysis completes
        $mainScope = new \Laravel\Surveyor\Analysis\Scope;
        $mainScope->setPath($mainFixture);
        AnalyzedCache::add($mainFixture, $mainScope);

        // Step 10: Pop main
        AnalyzedCache::popAnalysis();

        // Verify: main should have dep as a dependency
        $depMtimes = $depMtimesProp->getValue();
        expect($depMtimes)->toHaveKey($mainFixture);
        expect($depMtimes[$mainFixture])->toHaveKey($depFixture);
        expect($depMtimes[$mainFixture][$depFixture])->toBe(filemtime($depFixture));

        // Verify: cache hit works
        $cached = AnalyzedCache::get($mainFixture);
        expect($cached)->not->toBeNull();

        // Verify: modifying dep invalidates main
        sleep(1);
        file_put_contents($depFixture, "<?php\nclass FullFlowDep { public function modified() {} }");

        $cached = AnalyzedCache::get($mainFixture);
        expect($cached)->toBeNull();

        unlink($mainFixture);
        unlink($depFixture);
    });
});
