# Laravel Surveyor - Development Context

This document contains baseline information and context about the Laravel Surveyor project for development reference.

## Project Purpose

Laravel Surveyor is a static analysis tool designed to extract detailed PHP and Laravel-specific information from code files, including:

-   Method returns and arguments
-   Class structures and relationships
-   Type information from both PHP types and docblocks
-   Laravel-specific patterns and metadata

The primary goal is to transform this analyzed information into a digestible structure that can be consumed and used by other packages. It's essentially a code introspection/metadata extraction tool that provides comprehensive information about Laravel applications for further processing or tooling.

## Architecture Overview

### Core Components

-   **NodeResolvers**: Handle PHP AST nodes directly from php-parser
-   **DocBlockResolvers**: Handle PHPStan phpdoc-parser AST nodes for docblock analysis
-   **Scope**: Tracks analysis context and variable states
-   **Analysis Pipeline**: Processes files and extracts structured metadata

### Key Dependencies

-   `nikic/php-parser`: PHP AST parsing
-   `phpstan/phpdoc-parser`: DocBlock parsing and analysis
-   Laravel framework components for Laravel-specific analysis

## Development Patterns

### Adding New Resolvers

[To be documented - add your preferred patterns here]

### Output Structure

[To be documented - describe the final data structure format]

### Laravel-Specific Analysis

[To be documented - describe Laravel patterns being extracted]

## Current Focus Areas

[Update this section with current development priorities]

## Notes

-   PHP 8.2+ required
-   Uses Pest for testing
-   Integrates with Laravel service container
-   Built to be extensible for additional analysis needs
