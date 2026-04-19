# Database ERD and Class Diagram

## 1. ERD (ASCII)

```
+-----------------------------+      1   ────<      +-----------------------------+
|           Batch             |                      |          TestData           |
|-----------------------------|                      |-----------------------------|
| id PK                       |                      | id PK                       |
| product_name                |                      | batch_id FK -> Batch.id     |
| product_code UNIQUE         |                      | parameter_name              |
| batch_number UNIQUE         |                      | value (float)               |
| date_created                |                      | measurement_unit NULLABLE   |
| created_at                  |                      | created_at                  |
| updated_at                  |                      | updated_at                  |
+-----------------------------+                      |                             |
                                                    | INDEX(batch_id, parameter_name) |
                                                    +-----------------------------+
```

Keterangan:
- `Batch` memiliki banyak `TestData`.
- `TestData.batch_id` mengacu pada `Batch.id`.
- Relasi ini menggunakan aturan `ON DELETE CASCADE`, sehingga semua data `TestData` terkait ikut terhapus ketika `Batch` dihapus.

## 2. UML Class Diagram (ASCII)

```
+-----------------------------+
|           Batch             |
+-----------------------------+
| - id: int                   |
| - product_name: string      |
| - product_code: string      |
| - batch_number: string      |
| - date_created: date        |
| - created_at: timestamp     |
| - updated_at: timestamp     |
+-----------------------------+
| + testData(): hasMany(TestData) |
+-----------------------------+
            1
            |
            | hasMany
            |
            *
+-----------------------------+
|          TestData           |
+-----------------------------+
| - id: int                   |
| - batch_id: int             |
| - parameter_name: string    |
| - value: float              |
| - measurement_unit: string? |
| - created_at: timestamp     |
| - updated_at: timestamp     |
+-----------------------------+
| + batch(): belongsTo(Batch) |
+-----------------------------+
```
