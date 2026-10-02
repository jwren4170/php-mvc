# Copilot instructions

## Commands

There is no dependency manifest or configured build, test, or lint suite in this repository. Use PHP's built-in syntax checker for a file or a focused check:

```sh
php -l index.php
php -l src/controllers/products.php
php -l src/models/product.php
php -l view.php
```

Run the app locally from the repository root with `php -S localhost:8000`, then open `http://localhost:8000`. The controller uses the PHP 8.4+ `new ClassName()->method()` syntax.

## Architecture

`index.php` is the front controller: it loads `src/controllers/products.php`, creates `Products`, and calls `index()`. The controller loads the `Product` model, obtains product records, and includes the root-level `view.php`. The model queries the PostgreSQL `product` table through PDO and fetches rows as objects; the view expects those objects and renders their `name` and `description`. `style.css` styles that page.

This is a small, direct PHP MVC flow, not a framework-based or autoloaded application. File loading uses relative `require`/`include` paths from the project root.

## Repository conventions

- Keep the request flow in the front controller → controller → model → view; the controller prepares data and the view renders it.
- Classes are global and currently use simple singular model / plural controller names (`Product`, `Products`). Files use lowercase names under `src/models/` and `src/controllers/`.
- Database rows are fetched as objects (`PDO::FETCH_OBJ`); the view accesses product fields with `->`.
- Escape dynamic values when rendering HTML. The product view uses `htmlspecialchars()` for displayed fields.
- PostgreSQL connection settings currently live in the model. Do not copy credentials into documentation or new code; keep any future configuration changes out of tracked source.
