<?php

namespace PhpBounceMailParser;

class BounceCode
{
    /**
     * The given header which may include any bounce code
     * @var string
     */
    private $header = NULL;

    /**
     * All known bounce codes with their explanation
     *
     * @see http://help.pardot.com/customer/portal/articles/2128156-bounce-codes-reference
     * @var array
     */
    private static $CODES = array(
        'No reason found',

        '421'   => '<domain> Service not available, closing transmission channel',
        '450'   => 'Requested mail action not taken: mailbox unavailable (e.g., mailbox busy)',
        '451'   => 'Requested action aborted: error in processing',
        '452'   => 'Requested action not taken: insufficient system storage',
        '500'   => 'The server could not recognize the command due to a syntax error.',
        '501'   => 'A syntax error was encountered in command arguments.',
        '502'   => 'This command is not implemented.',
        '503'   => 'The server has encountered a bad sequence of commands.',
        '504'   => 'A command parameter is not implemented.',
        '550'   => 'User’s mailbox was unavailable (such as not found)',
        '551'   => 'The recipient is not local to the server.',
        '552'   => 'The action was aborted due to exceeded storage allocation.',
        '553'   => 'The command was aborted because the mailbox name is invalid.',
        '554'   => 'The transaction failed for some unstated reason.',
        '5.0.0' => 'Unknown issue',
        '5.1.0' => 'Other address status',
        '5.1.1' => 'Bad destination mailbox address',
        '5.1.2' => 'Bad destination system address',
        '5.1.3' => 'Bad destination mailbox address syntax',
        '5.1.4' => 'Destination mailbox address ambiguous',
        '5.1.5' => 'Destination mailbox address valid',
        '5.1.6' => 'Mailbox has moved',
        '5.1.7' => 'Bad sender\'s mailbox address syntax',
        '5.1.8' => 'Bad sender\'s system address',
        '5.2.0' => 'Other or undefined mailbox status',
        '5.2.1' => 'Mailbox disabled, not accepting messages',
        '5.2.2' => 'Mailbox full',
        '5.2.3' => 'Message length exceeds administrative limit.',
        '5.2.4' => 'Mailing list expansion problem',
        '5.3.0' => 'Other or undefined mail system status',
        '5.3.1' => 'Mail system full',
        '5.3.2' => 'System not accepting network messages',
        '5.3.3' => 'System not capable of selected features',
        '5.3.4' => 'Message too big for system',
        '5.4.0' => 'Other or undefined network or routing status',
        '5.4.1' => 'No answer from host',
        '5.4.2' => 'Bad connection',
        '5.4.3' => 'Routing server failure',
        '5.4.4' => 'Unable to route',
        '5.4.5' => 'Network congestion',
        '5.4.6' => 'Routing loop detected',
        '5.4.7' => 'Delivery time expired',
        '5.5.0' => 'Other or undefined protocol status',
        '5.5.1' => 'Invalid command',
        '5.5.2' => 'Syntax error',
        '5.5.3' => 'Too many recipients',
        '5.5.4' => 'Invalid command arguments',
        '5.5.5' => 'Wrong protocol version',
        '5.6.0' => 'Other or undefined media error',
        '5.6.1' => 'Media not supported',
        '5.6.2' => 'Conversion required and prohibited',
        '5.6.3' => 'Conversion required but not supported',
        '5.6.4' => 'Conversion with loss performed',
        '5.6.5' => 'Conversion failed',
        '5.7.0' => 'Other or undefined security status',
        '5.7.1' => 'Delivery not authorized, message refused',
        '5.7.2' => 'Mailing list expansion prohibited',
        '5.7.3' => 'Security conversion required but not possible',
        '5.7.4' => 'Security features not supported',
        '5.7.5' => 'Cryptographic failure',
        '5.7.6' => 'Cryptographic algorithm not supported',
        '5.7.7' => 'Message integrity failure'
    );

    public function __construct($header)
    {
        $this->header = $header;
    }

    /**
     * Get the code
     *
     * @return array
     */
    public function getCode()
    {
        if (preg_match_all('/[0-9]\.?[0-9]\.?[0-9]/', $this->header, $matches) > 0)
        {
            // Reverse order of matches that Enhanced Bounce Codes take precedence over Traditional Bounce Codes
            $matches = array_reverse($matches[0]);

            foreach ($matches as $match)
            {
                if (array_key_exists($match, self::$CODES))
                {
                    return array($match => self::$CODES[$match]);
                }
            }
        }

        return array(self::$CODES[0]);
    }
}