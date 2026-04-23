-- Grants the `app` user full privileges on any database matching `app_%`
-- (e.g. `app_test`). This lets Doctrine create and drop the test database
-- from `bin/console --env=test` without needing the root account.
-- Runs on fresh MySQL init via /docker-entrypoint-initdb.d.

GRANT ALL PRIVILEGES ON `app\_%`.* TO 'app'@'%';
FLUSH PRIVILEGES;
