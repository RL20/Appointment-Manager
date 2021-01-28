<?php
class CorsListener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            \Symfony\Component\HttpKernel\KernelEvents::REQUEST  => array('onKernelRequest', 9999),
            \Symfony\Component\HttpKernel\KernelEvents::RESPONSE => array('onKernelResponse', 9999),
        );
    }
    public function onKernelRequest(\Symfony\Component\HttpKernel\Event\GetResponseEvent $event)
    {
        printToTerminal('onKernelRequest');
        // Don't do anything if it's not the master request.
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        $method  = $request->getRealMethod();
        if ('OPTIONS' == $method) {
            $response = new \Symfony\Component\HttpFoundation\Response();
            $event->setResponse($response);
        }

    }
    public function onKernelResponse(\Symfony\Component\HttpKernel\Event\FilterResponseEvent $event)
    {
        printToTerminal('onKernelResponse');
        if (!$event->isMasterRequest()) {
            return;
        }
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization');
    }



}
?>