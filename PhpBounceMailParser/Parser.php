<?php

namespace PhpBounceMailParser;

use PhpBounceMailParser\BounceCode;

/**
 * Parse Bounce E-Mails and write csv result data
 *
 * These extensions are required
 * @see http://php.net/manual/de/book.mailparse.php
 * @see https://github.com/php-mime-mail-parser/php-mime-mail-parser
 */
class Parser
{
    const REASON_AUTORESPONDER = 'auto responder';

    /**
     * @var \PhpMimeMailParser\Parser
     */
    private $parser = NULL;

    /**
     * the line of the resource file
     *
     * @var array
     */
    private $lines = NULL;

    /**
     * Blacklist of emails which are ignored when try to find recipient of bounce mail
     *
     * @var array
     */
    private $emailBlacklist = array();

    /**
     * @var resource
     */
    private $csv = NULL;

    /**
     * @var string
     */
    private $csvDelimiter = ';';

    /**
     * @var string
     */
    private $csvEnclosure = '"';

    public function __construct()
    {
        $this->parser = new Parser();

        $this->ignoreEmail('Mail Delivery System');

        $tenMegabytes = 10 * 1024 * 1024;
        $this->csv = fopen("php://temp/maxmemory:$tenMegabytes", 'r+');

        if ($this->csv === FALSE)
        {
            throw new \Exception('Unable to open csv output stream');
        }
    }

    /**
     * Parse the given directory with email resources
     *
     * @param  string $directory path/to/directory
     * @return Parser
     */
    public function parseDirectory($directory)
    {
        if ( ! file_exists($directory))
            throw new Exception("Directory $directory does not exist.");

        $mails = array_diff(scandir($directory), array('.', '..'));

        foreach ($mails as $mail)
        {
            $this->parseFile($directory . '/' . $mail);
        }

        return $this;
    }

    /**
     * Parse the given email resource
     *
     * @param  string $file path/to/file
     * @return Parser
     */
    public function parseFile($file)
    {
        if ( ! file_exists($file))
            throw new Exception("File $file does not exist.");

        $this->lines = file($file);

        $this->parser->setPath($file);

        $bounceReason = $this->findBounceReason();

        fputcsv($this->csv, array(
                $this->findRecipient(),
                key($bounceReason),
                current($bounceReason)
            ),
            $this->csvDelimiter,
            $this->csvEnclosure
        );

        return $this;
    }

    /**
     * Output csv data
     *
     * @return void
     */
    public function outputCsv()
    {
        rewind($this->csv);
        $content = stream_get_contents($this->csv);
        fclose($this->csv);

        echo $content;
    }

    /**
     * Output csv data and save as file
     *
     * @return void
     */
    public function saveCsvAs()
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=bounces.csv');

        $this->outputCsv();
    }

    /**
     * Try to find bounce reason within email header
     *
     * @return array including error code as key and the reason as value e.g. array(550 => 'mailbox unavailable')
     */
    private function findBounceReason()
    {
        // Check if there is an diagnostic code in email header
        $result = array_filter($this->lines, array($this, 'findDiagnosticCode'));
        if (count($result) === 1)
        {
            $bounceCode = new BounceCode(substr(current($result), 17));
            return $bounceCode->getCode();
        }
        else
        {
            return array(self::REASON_AUTORESPONDER);
        }
    }

    /**
     * @param  string $line
     * @return array
     */
    private function findDiagnosticCode($line)
    {
        return preg_match('/^Diagnostic-Code:/', $line);
    }

    /**
     * @return string|null
     */
    private function findRecipient()
    {
        $email = null;
        $headers = array(
            'X-MS-Exchange-Inbox-Rules-Loop',
            'To',
            'From',
            'Delivered-To'
        );

        foreach ($headers as $header)
        {
            if (is_null($email))
            {
                $email = $this->findEmailInHeaderLine($header);
            }
        }

        return $email;
    }

    /**
     * @param  string $header
     * @return string|null
     */
    private function findEmailInHeaderLine($header)
    {
        $matches = array_filter($this->lines, function($line) use ($header)
        {
            return preg_match("/^$header:/", $line);
        });

        // remove blacklisted emails from matches
        foreach ($matches as $key => $match)
        {
            foreach ($this->emailBlacklist as $email)
            {
                if (strpos($match, $email) !== FALSE)
                {
                    unset($matches[$key]);
                }
            }
        }

        if (count($matches) > 0)
        {
            $email = end($matches);

            // Append second indented line
            if (array_key_exists(key($matches) + 1, $this->lines) &&
                ($this->lines[key($matches) + 1][0] === "\t" ||
                 substr($this->lines[key($matches) + 1], 0, 4) === "    "))
            {
                $email .= $this->lines[key($matches) + 1];
            }

            $email = substr($email, strlen($header) + 2);
            $email = trim($email);

            if (strpos($email, '<') !== FALSE &&
                preg_match('/<(.*?)>/si', $email, $email))
            {
                $email = $email[1];
            }

            return $email;
        }
    }

    /**
     * Set the csv delimiter
     *
     * @param string $delimiter
     * @return Parser
     */
    public function setCsvDelimiter($delimiter)
    {
        $this->csvDelimiter = $delimiter;
        return $this;
    }

    /**
     * Set the csv enclosure
     *
     * @param string $enclosure
     * @return Parser
     */
    public function setCsvEnclosure($enclosure)
    {
        $this->csvEnclosure = $enclosure;
        return $this;
    }

    /**
     * Add email to blacklist which is ignored when try to find an recipient in bounced mail
     *
     * @param  string $email
     * @return Parser
     */
    public function ignoreEmail($email)
    {
        array_push($this->emailBlacklist, $email);
        return $this;
    }
}
