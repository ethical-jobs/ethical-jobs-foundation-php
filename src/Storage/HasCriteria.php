<?php

namespace EthicalJobs\Foundation\Storage;

/**
 * Non specific criteria functionality
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

trait HasCriteria
{
    /**
     * Criteria collection
     *
     * @var Illuminate\Support\Collection
     */
    protected $criteria;    

    /**
     * {@inheritdoc}
     */
    public function setCriteriaCollection(CriteriaCollection $collection)
    {
    	$this->criteria = $collection;

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteriaCollection(): CriteriaCollection
    {
    	return $this->criteria;
    }

    /**
     * {@inheritdoc}
     */
    public function addCriteria(string $criteria)
    {
    	$this->criteria->push($criteria);

    	return $this;
    }   

    /**
     * Applies the criterion to the repository query
     *
     * @return void
     */
    protected function applyCriteria(): void
    {    
        foreach ($this->criteria as $criteria) {
            $criteria->apply($this);
        }
    }      
}