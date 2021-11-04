## User Authentication App for Databases Course (CodeSpace)

This project consisted of creating a user authentication app with a sign-up and log-in system for a dummy local library using PHP and MySQL. Access permissions had to be divided into regular member and admin roles. I used Bootstrap for styling, and implemented prepared statements and MySQLi/PDO to connect to a remote database.

Members are able to
* search for books based on the title
* view a table of all available books

Authors are able to
* search for a book based on the book title or author's name
* be able to perform CRUD operations, including adding new books or authors to the database table (create), viewing the existing data (read), and editing (update) and deleting (delete) an existing entry

All users can
* group books by genre
* sort table alphabetically, based on title, year, genre or author
* search functionality had to include the beginning letters or words of keywords or phrases
* all pages displaying book lists should only be accessible after log-in
