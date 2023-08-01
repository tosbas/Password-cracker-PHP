# Password-cracker-PHP

Password Cracker PHP with Wordlist

Exemple :
```
//The hash of password to test
$passwordHash = '$2y$10$M4OB3N9KhZPMaclw2vlh2OyS9uGiGw7cNXziPD9l.DakFUoKagZq2';

//Wordlist to use
$wordlist = "dict.txt";

$passwordCracker = (new passwordCracker($wordlist, $passwordHash))->testing(true);

echo $passwordCracker;
```
