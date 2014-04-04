<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\autogiro\Builder;

use ledgr\id\PersonalId;
use ledgr\banking\Bankgiro;

/**
 * Convert PersonalId and Bankgiro to autogiro formats
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 * @todo   Remove converter once builder does not use phpgiro
 */
class AutogiroConverter
{
    /**
     * Convert personal id to payer number
     *
     * @param  PersonalId $id
     * @return string
     * @todo   Bug: convertPayerNr is not only used with PersonalIds. See builder!
     */
    public function convertPayerNr(PersonalId $id)
    {
        return $id->getDate()->format('ymd')
            . $id->getIndividualNr()
            . $id->getCheckDigit();
    }

    /**
     * Convert personal id to ag format
     *
     * @param  PersonalId $id
     * @return string
     */
    public function convertId(PersonalId $id)
    {
        return $id->getDate()->format('Ymd')
            . $id->getIndividualNr()
            . $id->getCheckDigit();
    }

    /**
     * Convert bankgiro to ag format
     * 
     * @param  Bankgiro $bg
     * @return string
     * @todo   Bug: convertBankgiro is not only used with Bankgiro. See builder!
     */
    public function convertBankgiro(Bankgiro $bg)
    {
        return str_replace('-', '', $bg);
    }
}
