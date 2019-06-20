<?php

echo "Adjacency List (Linked List) <br/>";
echo "================================== <br/>";
$vertices = ['A', 'B', 'C', 'D', 'E'];

interface GraphType {
    public function addEdge($vertex, $vertexEdge);
    public function getTotalEdges();
}

class GraphRepresentation {
    
    protected $adjacencyGraph = [];
    protected $totalEdges = -1;
    
    public function __construct($vertices)
    {
        for ($i = 0; $i < count($vertices); $i++) {
            $this->adjacencyGraph[$vertices[$i]] = new SplDoublyLinkedList();
        }
    }
    
    public function printAllEdges() 
    {
        foreach($this->adjacencyGraph as $key => $vertexList) {
            echo "Adjacency list of vertex '".$key."' : <br/>";
            echo $key. " (head)";
            $this->printVertex($vertexList);
            echo '<br/>';
        }
    }
    
    public function printEdgeExists($vertexA, $vertexB)
    {
        echo "Does Vertex ". $vertexA . " and Vertex ". $vertexB . " has an edge ? => ". $this->isEdgeExists($vertexA, $vertexB) . '<br/>';
    }
    
    private function isEdgeExists($vertexA, $vertexB)
    {
        if (isset($this->adjacencyGraph[$vertexA])) {
            $vertexList = $this->adjacencyGraph[$vertexA];
            $vertexList->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
            for ($vertexList->rewind(); $vertexList->valid(); $vertexList->next()) {
                if ($vertexList->current() === $vertexB){
                    return 'TRUE';
                }
            }
            return 'FALSE';
        }
        
        return 'FALSE';
    }
    
    protected function setVertex($vertex, $vertexEdge)
    {
        $index = $this->adjacencyGraph[$vertex]->key();
        if (!$this->adjacencyGraph[$vertex]->isEmpty()) {
            $index = $index + 1;
        }
        $this->adjacencyGraph[$vertex]->add($index, $vertexEdge);
    }
    
    private function printVertex($vertexList)
    {
        $vertexList->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
        for ($vertexList->rewind(); $vertexList->valid(); $vertexList->next()) {
            echo " -> ".$vertexList->current();
        }
    }
}


echo "Adjacency Graph Directed Representation : <br/>";

class AdjacencyGraphDirected extends GraphRepresentation implements GraphType {
    public function addEdge($vertex, $vertexEdge) 
    {
        $this->setVertex($vertex, $vertexEdge);
    }
    
    public function getTotalEdges()
    {
        array_walk($this->adjacencyGraph, function($vertex) {
            $this->totalEdges += $vertex->count();
        });
        return $this->totalEdges;
    }
}

$graph = new AdjacencyGraphDirected($vertices);
$graph->addEdge('A', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('B', 'D');
$graph->addEdge('B', 'E');
$graph->addEdge('C', 'D');
$graph->addEdge('D', 'A');
$graph->addEdge('D', 'D');
$graph->addEdge('D', 'E');
echo 'Number of vertices : '. count($vertices). '<br/>';
echo 'Number of edges : '. $graph->getTotalEdges(). '<br/>'; 
$graph->printAllEdges(); 
$graph->printEdgeExists('A', 'E');
$graph->printEdgeExists('C', 'D');
$graph->printEdgeExists('C', 'C');
$graph->printEdgeExists('B', 'D');
$graph->printEdgeExists('D', 'D');
$graph->printEdgeExists('E', 'B');

echo "<br/>";
echo "<br/>";
echo "Adjacency Graph Undirected Representation : <br/>";
class AdjacencyGraphUndirected extends GraphRepresentation implements GraphType {
    public function addEdge($vertex, $vertexEdge) 
    {
        $this->setVertex($vertex, $vertexEdge);
        $this->setVertex($vertexEdge, $vertex);
    }
    
    public function getTotalEdges()
    {
        array_walk($this->adjacencyGraph, function($vertex) {
            $this->totalEdges += $vertex->count();
        });
        return $this->totalEdges/2;
    }
}


$graph = new AdjacencyGraphUndirected($vertices);
$graph->addEdge('A', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('B', 'D');
$graph->addEdge('B', 'E');
$graph->addEdge('C', 'D');
$graph->addEdge('D', 'A');
$graph->addEdge('D', 'D');
$graph->addEdge('D', 'E');
echo 'Number of vertices : '. count($vertices). '<br/>';
echo 'Number of edges : '. $graph->getTotalEdges(). '<br/>'; 
$graph->printAllEdges(); 
$graph->printEdgeExists('A', 'E');
$graph->printEdgeExists('C', 'D');
$graph->printEdgeExists('C', 'C');
$graph->printEdgeExists('B', 'D');
$graph->printEdgeExists('D', 'D');
$graph->printEdgeExists('E', 'B');

?>

