<?php
namespace Magento\Framework\App\PageCache\Kernel;

/**
 * Interceptor class for @see \Magento\Framework\App\PageCache\Kernel
 */
class Interceptor extends \Magento\Framework\App\PageCache\Kernel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\PageCache\Cache $cache, \Magento\Framework\App\PageCache\IdentifierInterface $identifier, \Magento\Framework\App\Request\Http $request, ?\Magento\Framework\App\Http\Context $context = null, ?\Magento\Framework\App\Http\ContextFactory $contextFactory = null, ?\Magento\Framework\App\Response\HttpFactory $httpFactory = null, ?\Magento\Framework\Serialize\SerializerInterface $serializer = null, ?\Magento\Framework\App\State $state = null, ?\Magento\PageCache\Model\Cache\Type $fullPageCache = null, ?\Magento\Framework\App\PageCache\IdentifierInterface $identifierForSave = null, ?\Magento\Framework\Stdlib\CookieDisablerInterface $cookieDisabler = null)
    {
        $this->___init();
        parent::__construct($cache, $identifier, $request, $context, $contextFactory, $httpFactory, $serializer, $state, $fullPageCache, $identifierForSave, $cookieDisabler);
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        return $pluginInfo ? $this->___callPlugins('load', func_get_args(), $pluginInfo) : parent::load();
    }

    /**
     * {@inheritdoc}
     */
    public function process(\Magento\Framework\App\Response\Http $response)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'process');
        return $pluginInfo ? $this->___callPlugins('process', func_get_args(), $pluginInfo) : parent::process($response);
    }
}
