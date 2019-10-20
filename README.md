CRUD console application

Implements Create, Read, Update, Delete operations.

1) Command arguments:
	
	-create - takes one or more parameters in the format:

			-create parameter1=<value1> parameter2=<value2> ...("<value>" if it contains spaces)

	-read - takes one or more parameters in to format:

			-read parameter1 parameter2 ...

		if certain entries are targeted, this argument should be combined with -match ...
		otherwise, everything is returned, depending on the parameters

	-update - takes one or more parameters in the format:

			-create parameter1=<value1> parameter2=<value2> ...("<value>" if it contains spaces)

		if certain entries are targeted, this argument should be combined with -match ...
		otherwise, the fields, corresponding to the parameters, are changed throughout the whole DB

	-delete - takes no parameters(provided parameters are ignored)
		if certain entries are targeted, this argument should be combined with -match ...
		otherwise, whole table is cleared

	-search - takes no parameters(provided parameters are ignored)
		returns the number of entries in the DB, that correspond to the requirements
		if certain entries are targeted, this argument should be combined with -match ...
		otherwise, the number of all entries in the DB is returned

	-match - takes one or more parameters in the format:

			-match parameter1=<value1> parameter2=<value2> ...("<value>" if it contains spaces)

	Note: Exactly one of the arguments -create, -read, -update, -delete and -search is required.


IMPORTANT! Not following the manual can result in an unpredictable behaviour!

2) Examples

	2.1) -read

		php index.php -read name -match id=1 <=> SELECT name FROM <table_name> WHERE id=1;

		php index.php -read name id type -match description="description 1" type="new type"
						<=>
		SELECT name, id, type FROM <table_name> WHERE description="description 1" AND type="new type";

		php index.php -read <=> SELECT * FROM <table_name>;

	2.2) -create
		php index.php -create id=1 name="My name" <=> INSERT INTO <table_name> (id, name) VALUES (1, "My name");

	2.3) -update
		php index.php -update name="My New Name" type="My New Type" -match id=1
						<=>
		UPDATE <table_name> SET name="My New Name", type="My New Type" WHERE id=1;

	2.4) -delete
		php index.php -delete -match id=2 <=> DELETE FROM <table_name> WHERE id=2;

	2.5)-search - same as -read, but returns the number of results


IMPORTANT! Not following the manual can result in an unpredictable behaviour!

3) DB Used in the application(just for reference)

	DB Name - menu
	DB field - id, name, price, ingredients, description, type, menu_type