<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\HelloWorld\Controller\Adminhtml\Post;

use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;
use Tigren\HelloWorld\Model\PostFactory;

//use Magento\Framework\App\ActionContext;


/**
 * Class Save
 * @package Tigren\HelloWorld\Controller\Adminhtml\Post
 */
class Save extends Action
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * Save constructor.
     * @param ActionContext $context
     * @param PostFactory $postFactory
     */
    public function __construct(
        ActionContext $context,
        PostFactory   $postFactory
    )
    {
        parent::__construct($context);
        $this->postFactory = $postFactory;
    }

    /**
     * @return Redirect
     * @throws Exception
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['post_id']) ? $data['post_id'] : null;
        $newData = [
            'name' => $data['name'],
            'status' => $data['status'],
            'content' => $data['content'],
        ];
        $post = $this->postFactory->create();
        if ($id) {
            $post->load($id);
        }
        try {
            $post->addData($newData);
            $post->save();
            $this->messageManager->addSuccessMessage(__('You saved the post.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        return $this->resultRedirectFactory->create()->setPath('helloworld/post/index');
    }
}
