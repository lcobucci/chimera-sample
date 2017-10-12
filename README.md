# Chimera - sample

This project is a simple example of what can be achieved using `lcobucci/chimera-*`
libraries.

It doesn't show anything about the other route types (`execute`, `execute_fetch`,
and `create_fetch`) but it should be easy to get the idea (`execute_fetch` and
`create_fetch` just requires `query` AND `command` attributes on the tag).

There are some limitations for now but, you know, it's an alpha release.

## Usage

You can simply clone (or use this package as skeleton) and run `composer run-script 
--timeout 0 serve`, which will expose the port `1234`.

**Important:** by running that composer script the application will be executed
using "production mode", which means that the container will not be modified
when any configuration file changes. If you want to try out the "development
mode" use: `APPLICATION_MODE=dev composer run-script --timeout 0 serve`

### Endpoints

- **GET** /books: returns the entire book collection (can be optionally
filtered using `title` and `author` params on the query string)
- **POST** /book: appends a new book to the collection (receives a JSON object
with `title` and `author`, no fancy validation for now)
- **GET** /books/{id}: returns a book from the book collection
