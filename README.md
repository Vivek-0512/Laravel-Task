# Laravel-Task
Order transaction commit and rollback 

step 1
create job:  php artisan make:job ProcessOrderJob

step 2
Creates an order in the database

Ensures data integrity using a database transaction

Processes the order asynchronously using a queued job

Rolls back the database if anything fails

