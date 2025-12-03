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
