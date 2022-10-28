<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\GroupCat;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Tigren\CustomerGroupCatalog\Model\GroupCat;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\GroupCat\CollectionFactory;

class Delete extends Action
{
    private $groupCat;
    private $filter;
    private $collectionFactory;
    private $resultRedirect;

    public function __construct(
        Context           $context,
        GroupCat          $groupCat,
        Filter            $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory   $redirectFactory
    ) {
        parent::__construct($context);
        $this->groupCat = $groupCat;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deleteGroupCat = $this->groupCat->create()->load($item->getData('rule_id'));
            try {
                $deleteGroupCat->delete();
                $total++;
            } catch (LocalizedException $exception) {
                $err++;
            }
        }
        if ($total) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $total)
            );
        }
        if ($err) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven’t been deleted. Please see server logs for more details.',
                    $err
                )
            );
        }
        return $this->resultRedirect->create()->setPath('helloworld/post/index');
    }
}
