Lokasi file ini ditaruh di folder /skills.

| name | laravel-qc-input |
| --- | --- |
| description | Get best practices for implementing QC data input features in Laravel applications using the provided database schema. |

# Laravel QC Data Input Best Practices

Your goal is to help me implement high-quality QC data input features in Laravel applications using the provided database schema for batches and test data.

## Database Migrations

• Table Structure: Use the provided schema for 'batches' and 'test_data' tables to ensure proper relationships and constraints.
• Primary Keys: Utilize auto-incrementing IDs for both tables.
• Foreign Keys: Implement foreign key constraints with cascade delete for 'test_data' referencing 'batches'.
• Unique Constraints: Enforce uniqueness on 'product_code' and 'batch_number' in 'batches' table.
• Indexes: Add composite index on 'batch_id' and 'parameter_name' in 'test_data' for query performance.
• Timestamps: Include 'created_at' and 'updated_at' fields for audit trails.

## Eloquent Models

• Model Classes: Create Batch and TestData models extending Eloquent Model.
• Relationships: Define one-to-many relationship from Batch to TestData.
• Fillable Attributes: Specify fillable attributes to protect against mass assignment.
• Accessors/Mutators: Use accessors for formatting values or units if needed.
• Scopes: Implement query scopes for filtering batches or test data by parameters.

## Controllers

• Resource Controllers: Use Laravel's resource controllers for CRUD operations on batches and test data.
• Validation: Implement form request validation classes for input data.
• Dependency Injection: Inject models or services into controllers for better testability.
• API Responses: Return JSON responses for API endpoints, using Laravel's API resources if needed.
• Error Handling: Use try-catch blocks and Laravel's exception handling for graceful error responses.

## Validation

• Form Request Classes: Create custom form request classes for validating batch and test data inputs.
• Rules: Define validation rules for required fields, data types, and uniqueness.
• Custom Validation: Implement custom validation rules for specific QC parameter constraints.
• Error Messages: Provide user-friendly error messages in multiple languages if needed.

## Routes

• RESTful Routes: Define RESTful routes for batches and nested routes for test data.
• Route Model Binding: Use implicit route model binding for cleaner controller methods.
• Middleware: Apply authentication and authorization middleware to protect routes.
• API Versioning: Consider API versioning for future extensibility.

## Views and Frontend

• Blade Templates: Use Blade for server-side rendered views if not using SPA.
• Form Handling: Implement forms with CSRF protection for data input.
• JavaScript Integration: Use Laravel Mix or Vite for compiling assets and handling client-side interactions.
• Data Tables: Integrate data tables for displaying batches and test data with sorting and filtering.

## Testing

• Feature Tests: Write feature tests for controller endpoints and user workflows.
• Unit Tests: Test model relationships, validation rules, and business logic.
• Database Testing: Use in-memory SQLite for fast database tests.
• Factories: Create model factories for generating test data.
• Assertions: Use Laravel's test assertions for HTTP responses and database state.

## Security

• Authentication: Implement user authentication using Laravel's built-in auth system.
• Authorization: Use policies or gates for controlling access to batches and test data.
• Input Sanitization: Ensure all inputs are properly sanitized and validated.
• CSRF Protection: Enable CSRF protection on all forms.

## Performance

• Eager Loading: Use eager loading to prevent N+1 query problems when retrieving related data.
• Caching: Implement caching for frequently accessed data using Laravel's cache system.
• Pagination: Use pagination for large datasets in listings.
• Database Optimization: Monitor and optimize queries using Laravel Debugbar or similar tools.

## Additional Links

- [Laravel Documentation](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel Testing](https://laravel.com/docs/testing)