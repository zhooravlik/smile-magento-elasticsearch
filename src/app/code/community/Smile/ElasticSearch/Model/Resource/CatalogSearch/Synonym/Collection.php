<?php
/**
 * Synonym list generator.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Smile Searchandising Suite to newer
 * versions in the future.
 *
 * This work is a fork of Johann Reinke <johann@bubblecode.net> previous module
 * available at https://github.com/jreinke/magento-elasticsearch
 *
 * @category  Smile
 * @package   Smile_ElasticSearch
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2013 Smile
 * @license   Apache License Version 2.0
 */
class Smile_ElasticSearch_Model_Resource_CatalogSearch_Synonym_Collection extends Mage_CatalogSearch_Model_Resource_Query_Collection
{
    /**
     * Generates the synonym list for the search engine.
     *
     * @return return array
     */
    public function exportSynonymList()
    {
        $result = array();
        $this->addFieldToFilter('synonym_for', array('notnull' => true));
        $this->addFieldToSelect(array('query_text', 'synonym_for'));
        $adapter = $this->getConnection();
        $data = $adapter->fetchAll($this->getSelect());
        foreach ($data as $currentTerm) {
            $currentTerm['synonym_for'] = sprintf('%s, %s', $currentTerm['query_text'], $currentTerm['synonym_for']);
            $result[] = sprintf("%s => %s", $currentTerm['query_text'], $currentTerm['synonym_for']);
        }

        return $result;
    }
}