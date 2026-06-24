Done — I created the full project with all admin CRUD files and 10 sample apps, and packaged it into a ZIP ready for download.

[Download the ZIP (portfolio_catalog_complete.zip)](sandbox:/mnt/data/portfolio_catalog_complete.zip)

Quick setup:

1. Unzip into XAMPP `htdocs` (e.g. `C:\xampp\htdocs\portfolio_catalog`).
2. Import `sql/portfolio_db.sql` into phpMyAdmin.
3. Ensure `assets/uploads/` is writable.
4. Admin login: **admin / admin123**
5. Public catalog: `http://localhost/portfolio_catalog/index.php`
6. Admin: `http://localhost/portfolio_catalog/admin/login.php`

Notes & recommendations:

* I used MD5 for sample passwords to match your requested simple setup. For production, I strongly recommend migrating to `password_hash()` / `password_verify()` and updating the DB — I can do that next.
* I used CDN links for Bootstrap, jQuery and TinyMCE so the app requires internet access.

Want me to:

* Migrate authentication to `password_hash()` and update the SQL/users automatically?
* Or harden SQL queries using prepared statements across the project?
