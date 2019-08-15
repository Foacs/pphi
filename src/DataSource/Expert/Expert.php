<?php
/**
 * Copyright Foacs
 * contributor(s): Alexis DINQUER
 *
 * (2019-05-09)
 *
 * contact@foacs.me
 *
 * This software is a computer program whose purpose is to handle data persistence in PHP
 *
 * This software is governed by the CeCILL-C license under french law and
 * abiding by the rules of distribution of free software. You can use,
 * modify and/ or redistribute the software under the terms of the CeCILL-C
 * license as circulated by CEA, CNRS and INRIA at the follow URL
 * "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and rights to copy,
 * modify and redistribute granted by the license, users are provided only
 * with a limited warranty and the software's authors, the holder of the
 * economic rights, and the successive licensors have only limited
 * liability.
 *
 * In this respect, the user's attention is drawn to the risk associated
 * with loading, using, modifying and/ or developing or reproducing the
 * software by the user in light of its specific status of free software,
 * that may mean that it is complicated to manipulate, and that also
 * therefore means that it is reserved for developers and experienced
 * professionals having in-depth computer knowledge. Users are therefore
 * encouraged to load and test the software's suitability as regards their
 * requirements in conditions enabling the security of their systems and/or
 * data to be ensure and, more generally, to use and operate it in the
 * same conditions as regards security.
 *
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL-C license and that you accept its terms.
 */

namespace PPHI\DataSource\Expert;

use PPHI\DataSource\Source\DataSource;

/**
 * Class Expert
 * An expert is used to resolved the data source type.
 * It's used in a linked chain of expert
 *
 * @package PPHI\DataSource\Expert
 * @version 0.1.0
 * @api
 * @license CeCILL-C
 * @author Foacs
 */
abstract class Expert
{
    /**
     * @var Expert
     */
    private $next;

    /**
     * Process the string given in parameter, return the found dataSource or null even.
     * If return null, the processor will call try with the next expert.
     *
     * @param string $str The string which will be processed
     * @return DataSource|null The result
     */
    abstract public function execute(string $str): ?DataSource;

    /**
     * Get the next expert in the chain.
     *
     * @return Expert The next expert
     */
    public function getNext(): ?Expert
    {
        return $this->next;
    }

    /**
     * Set the next expert in the chain
     *
     * @param Expert $next next expert in the chain
     */
    public function setNext(?Expert $next): void
    {
        $this->next = $next;
    }
}
