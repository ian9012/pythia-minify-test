<?php

declare(strict_types=1);

namespace Book\Action;

use Book\Entity\Book;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class BookAction implements RequestHandlerInterface, EventManagerAwareInterface
{
    private $resourceGenerator;
    private $halResponseFactory;
    protected $events;

    public function __construct(ResourceGenerator $resourceGenerator , HalResponseFactory $halResponseFactory)
    {
        $this->resourceGenerator = $resourceGenerator;
        $this->halResponseFactory = $halResponseFactory;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $book = $this->getBook();
        $resource = $this->resourceGenerator->fromObject($book, $request);
        return $this->halResponseFactory->createResponse($request, $resource);
    }

    private function getBook()
    {
        $book = new Book();
        $book->setId(90);
        $book->setAuthor('AUthor Kong');
        $book->setTitle('James bund');
        $this->getEventManager()->trigger('getBook', $this, [
            'id' => $book->getId(),
            'author' => $book->getAuthor(),
            'title' => $book->getTitle()
        ]);
        return $book;
    }

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_called_class(),
        ]);
        $this->events = $events;
        return $this;
    }

    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}
