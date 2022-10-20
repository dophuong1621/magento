<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\HelloWorld\Controller\Adminhtml\Post;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory;

//use Magento\Framework\App\ActionContext;
use Magento\Ui\Component\MassAction\Filter;
use Tigren\HelloWorld\Model\PostFactory;
use Tigren\HelloWorld\Model\ResourceModel\Post\CollectionFactory;

/**
 * Class Delete
 * @package Tigren\HelloWorld\Controller\Adminhtml\Post
 */
class Delete extends Action
{
    /**
     * @var PostFactory
     */
    private $postFactory;
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var RedirectFactory
     */
    private $resultRedirect;

    /**
     * @param ActionContext $context
     * @param PostFactory $postFactory
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        ActionContext     $context,
        PostFactory       $postFactory,
        Filter            $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory   $redirectFactory
    )
    {
        parent::__constrluct($context);
        $this->postFactory = $postFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    /**
     * @return Redirect
     * @throws Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deletePost = $this->postFactory->create()->load($item->getData('post_id'));
            try {
                $deletePost->delete();
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
