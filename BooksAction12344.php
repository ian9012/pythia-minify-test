<?php

declare(strict_types=1);

namespace Book\Action;

use Book\Entity\Book;
use Book\Entity\BookCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;
use Zend\Paginator\Adapter\ArrayAdapter;

class BooksAction implements RequestHandlerInterface
{
    private $resourceGenerator;
    private $halResponseFactory;

    public function __construct(ResourceGenerator $resourceGenerator , HalResponseFactory $halResponseFactory)
    {
        $this->resourceGenerator = $resourceGenerator;
        $this->halResponseFactory = $halResponseFactory;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $books = [$this->getBook(1), $this->getBook(2), $this->getBook(3), $this->getBook(4), $this->getBook(5)];
        $collection = new BookCollection(new ArrayAdapter($books));
        $collection->setCurrentPageNumber($page);
        $collection->setItemCountPerPage(2);
        $resource = $this->resourceGenerator->fromObject($collection, $request);
        return $this->halResponseFactory->createResponse($request, $resource);
    }

    private function getBook($id)
    {
        $book = new Book();
        $book->setId($id);
        $book->setAuthor('Author'.rand(0, 100).' Kong');
        $book->setTitle('James bund'.rand(33, 1000));
        return $book;
    }
}
