<?php

session_start();

class Cron {
    const EVERY_MINUTE = 60;
    const EVERY_FIVE_MINUTES = 300;
    const EVERY_FIFTEEN_MINUTES = 900;
    const EVERY_HALF_HOUR = 1800;
    const EVERY_HOUR = 3600;
    const EVERY_DAY = 43200;
    
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function every($every)
    {
        $this->every = $every;

        return $this;
    }

    public function save()
    {
        $cron = Database::run('SELECT `file`, `every` FROM `cron` WHERE `file` = ?', [$this->file]);

        if ($cron->rowCount() === 1) {
            if ($cron->fetch()->every !== $this->every)
                Database::run('UPDATE `cron` SET `every` = ?, `next_execution` = ? WHERE `file` = ?', [$this->every, time() + $this->every, $this->file]);
        } else {
            Database::run('INSERT INTO `cron` (`file`, `every`, `next_execution`) VALUES (?, ?, ?)', [$this->file, $this->every, time() + $this->every]);
        }
        
        return $this;
    }

    public function complete($func)
    {
        $cron = Database::run('SELECT `file`, `every`, `next_execution` FROM `cron` WHERE `file` = ?', [$this->file])->fetch();

        if (time() >= $cron->next_execution) {
            $overdue_by = floor( ( time() - $cron->next_execution ) / $cron->every);

            if (is_callable($func)) {
                $func($overdue_by);
            }

            Database::run('UPDATE `cron` SET `next_execution` = ? WHERE `file` = ?', [time() + $cron->every, $cron->file]);
        }
    }
}
