

Before launching init.php you should configure Constants.php with db data,
redis cli should be installed, php scripts chould be executable.

Also you have to create table:
    create table `test` (`sum` varchar(500),  `count_fib` SMALLINT, `count_prime` SMALLINT) ENGINE=InnoDB CHARSET=utf8;
and prepare it executing:
    insert into test (sum,count_fib,count_prime) values(0,0,0);

If you have redis keys "primes" or "fibonacci" - delete it or make lists empty.
