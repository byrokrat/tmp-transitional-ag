<?php
/**
 * This file is part of the swegiro package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\swegiro\Sniffer;

use iio\swegiro\Exception\SnifferException;

/**
 * Sniff the layout type of a giro file
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface SnifferInterface
{
    /**
     * Sniff the layout type of a giro file
     *
     * @param  array            $lines The file contents
     * @return scalar           Layout identifier
     * @throws SnifferException If sniff fails
     */
    public function sniffGiroType(array $lines);
}