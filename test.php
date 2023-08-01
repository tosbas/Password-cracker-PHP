<?php

declare(strict_types=1);

/**
 * Password cracker
 * @param array $wordlist The wordlist
 * @param string $password The hash of the password
 */
class passwordCracker
{
    public string $wordlist;
    public string $passwordHash;

    static string $version = "1.0.0";
    static int $wordTest = 1;
    static int $counterWordlist = 0;

    function __construct(string $wordlist, string $passwordHash)
    {
        $this->wordlist = $wordlist;
        $this->passwordHash = $passwordHash;

        // Check if the wordlist file exists before proceeding
        if (!file_exists($this->wordlist)) {
            throw new Exception("Wordlist file \"$this->wordlist\" not found in " . __DIR__);
        }

        self::$counterWordlist = count(file($this->wordlist));
    }

    /**
     * Testing the password
     * @param bool $viewProcess View the process, false by default
     * @return string Result of password cracking attempt
     */
    function testing($viewProcess = false)
    {
        echo "Password cracker by Tosbas (" . self::$version . ")\n";
        echo "Hash : " . $this->passwordHash . "\n";
        echo "Wordlist : " . $this->wordlist . "\n\n";

        sleep(1);

        $startime = microtime(true);

        $hash = $this->passwordHash;

        $handle = fopen($this->wordlist, "r");

        if ($handle) {
            while (($password = fgets($handle)) !== false) {
                $password = rtrim($password, "\n");

                if ($viewProcess) {
                    echo sprintf("Testing password : %d/%d (%s)", self::$wordTest, self::$counterWordlist, $password) . PHP_EOL;
                }

                if (password_verify($password, $hash)) {
                    $endtime = microtime(true);
                    $time = $endtime - $startime;

                    $reponse = sprintf("PASSWORD FOUND => \"%s\" in %f seconds", $password, $time);
                    return PHP_EOL . $reponse . PHP_EOL;
                }

                self::$wordTest += 1;
            }

            fclose($handle);
        } else {
            // The file exists, but cannot be opened (unlikely scenario)
            $error = sprintf("Unable to open file \"%s\"", $this->wordlist);
            throw new Exception($error);
        }

        $reponse = "Password not found ...";
        return  PHP_EOL . $reponse . PHP_EOL;
    }
}

//The hash of password to test
$passwordHash = '$2y$10$M4OB3N9KhZPMaclw2vlh2OyS9uGiGw7cNXziPD9l.DakFUoKagZq2';

//Wordlist to use
$wordlist = "dict.txt";

try {
    //Init password cracker
    $passwordCracker = (new passwordCracker($wordlist, $passwordHash))->testing(true);
    echo $passwordCracker;
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage() . PHP_EOL;
}
