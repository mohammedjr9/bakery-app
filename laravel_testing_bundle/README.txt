
Laravel Testing Bundle

Files included:
- tests/Unit/BeneficiaryServiceTest.php
- tests/Feature/BeneficiaryToReportTest.php
- tests/Feature/SystemFlowTest.php
- tests/Browser/UatBeneficiaryFlowTest.php   (requires: composer require --dev laravel/dusk && php artisan dusk:install)
- app/Console/Commands/BenchmarkBulkImport.php
- database/factories/BeneficiaryFactory.php
- database/migrations/2025_01_01_000000_create_beneficiaries_table.php

Quick Start:
1) Copy folders into your Laravel project root (they will merge into existing folders).
2) Run migrations: php artisan migrate
3) Run PHPUnit tests: php artisan test
4) Run Dusk (browser tests): php artisan dusk
5) Run performance command: php artisan benchmark:bulk-import 5000

Notes:
- Adjust routes (/beneficiaries, /reports) if your app uses different endpoints.
- Ensure authentication scaffolding exists (e.g., Laravel Breeze/Jetstream) for login-related tests.
