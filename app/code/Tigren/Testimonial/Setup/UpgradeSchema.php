<!--if (version_compare($context->getVersion(), '1.0.0.2') < 0) {-->
<!---->
<!--/**-->
<!--* Add full text index to our table department-->
<!--*/-->
<!---->
<!--$tableName = $installer->getTable('maxime_department');-->
<!--$fullTextIntex = array('name'); // Column with fulltext index, you can put multiple fields-->
<!---->
<!---->
<!--$setup->getConnection()->addIndex(-->
<!--$tableName,-->
<!--$installer->getIdxName($tableName, $fullTextIntex, \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT),-->
<!--$fullTextIntex,-->
<!--\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT-->
<!--);-->
<!---->
<!--/**-->
<!--* Add full text index to our table jobs-->
<!--*/-->
<!---->
<!--$tableName = $installer->getTable('maxime_job');-->
<!--$fullTextIntex = array('title', 'type', 'location', 'description'); // Column with fulltext index, you can put multiple fields-->
<!---->
<!---->
<!--$setup->getConnection()->addIndex(-->
<!--$tableName,-->
<!--$installer->getIdxName($tableName, $fullTextIntex, \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT),-->
<!--$fullTextIntex,-->
<!--\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT-->
<!--);-->
<!---->
<!--}-->
