<?php

namespace EthicalJobs\Foundation\Storage;

/**
 * Interface Repository Criteria
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface RepositoryCriteria
{
    /**
     * Sets the criteria collection
     * 
     * @param EthicalJobs\Foundation\Storage\CriteriaCollection $collection
     * @return $this
     */
    public function setCriteriaCollection(CriteriaCollection $collection);

    /**
     * Gets the criteria collection
     * 
     * @return EthicalJobs\Foundation\Storage\CriteriaCollection
     */
    public function getCriteriaCollection(): CriteriaCollection;

    /**
     * Push a new criteria onto the collection
     *
     * @param string $criteria
     * @return $this
     */
    public function addCriteria(string $criteria);
}