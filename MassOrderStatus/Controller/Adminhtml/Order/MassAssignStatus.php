<?php
namespace Rvs\MassOrderStatus\Controller\Adminhtml\Order;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

class MassAssignStatus extends \Magento\Backend\App\Action implements HttpPostActionInterface
{	
	/**
	* Authorization level of a basic admin session
	*/
	const ADMIN_RESOURCE = 'Magento_Sales::massstatuses';

	/**
	* @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
	*/
	protected $collectionFactory;

	/**
	* @var Filter
	*/
	protected $filter;

	/**
	* @var \Magento\Sales\Api\OrderRepositoryInterface
	*/
	protected $orderRepository;

	protected $redirectUrl = '*/*/';
	/**
	* Preparation constructor.
	* @param Context $context
	* @param Filter $filter
	* @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
	* @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
	*/
	public function __construct(
		Context $context,
		Filter $filter,
		\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
		\Magento\Sales\Api\OrderRepositoryInterface $orderRepository
	) {
		parent::__construct($context);
		$this->collectionFactory = $orderCollectionFactory;
		$this->orderRepository = $orderRepository;
		$this->filter = $filter;
	}
	
	public function execute()
	{
		try 
		{
			$collection = $this->filter->getCollection($this->collectionFactory->create());
			//mass action
			$countPreparationOrder = 0;
			/** @var \Magento\Sales\Model\Order $order */
			foreach ($collection->getItems() as $order) {
				/* if ($order->getState() != \Magento\Sales\Model\Order::STATE_NEW) {
					continue;
				} */
				$order->setStatus($this->getRequest()->getParam('status'));
				$this->orderRepository->save($order);				
				$countPreparationOrder++;
			}
			
			$countNonPreparationOrder = $collection->count() - $countPreparationOrder;
			
			if ($countNonPreparationOrder && $countPreparationOrder) {
				$this->messageManager->addErrorMessage(__('%1 order(s) cannot be changed.', $countNonPreparationOrder));
			} elseif ($countNonPreparationOrder) {
				$this->messageManager->addErrorMessage(__('You cannot change order(s) status.'));
			}

			if ($countPreparationOrder) {
				$this->messageManager->addSuccessMessage(__('Status for %1 order(s) updated.', $countPreparationOrder));
			}

			$resultRedirect = $this->resultRedirectFactory->create();
			$resultRedirect->setPath($this->filter->getComponentRefererUrl() ?: 'sales/*/');
			return $resultRedirect;
		} catch (\Exception $e) {
			$this->messageManager->addErrorMessage($e->getMessage());
			/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
			$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
			return $resultRedirect->setPath($this->redirectUrl);
		}
	}
}
