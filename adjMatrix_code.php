<?php

echo "Adjacency Matrix (Array) : <br/>";
echo "================================== <br/>";
interface GraphType {
    public function addEdge($vertex, $vertexEdge);
    public function getTotalEdges();
}

class Graph {
    protected $graph = [];
    protected $totalEdges = 0;
    
    public function __construct($vertices)
    {
        $this->initializeNodes($vertices);
    }
    
    private function initializeNodes($vertices)
    {
        for ($i = 0; $i < count($vertices); $i++) {
            $this->graph[$vertices[$i]] = [];
        }
    }
    
    public function printEdgeExists($vertexA, $vertexB)
    {
        echo "Does Vertex ". $vertexA . " and Vertex ". $vertexB . " has an edge ? => ". $this->isEdgeExists($vertexA, $vertexB) . '<br/>';
    }
    
    private function isEdgeExists($vertexA, $vertexB)
    {
        if (isset($this->graph[$vertexA])) {
            return in_array($vertexB, $this->graph[$vertexA]) ? 'TRUE' : 'FALSE';
        }
        
        return 'FALSE';
    }
    
    public function printAllEdges()
    {
        foreach($this->graph as $vertex => $vertexEdge) {
            for ($i = 0; $i < count($vertexEdge); $i++) {
                echo 'showing edge from vertex '.$vertex.' to vertex '.$vertexEdge[$i]. '<br/>';
            }
        }
    }
}
    
class DirectedGraph extends Graph implements GraphType {
    public function addEdge($vertex, $vertexEdge)
    {
        array_push($this->graph[$vertex], $vertexEdge);
    }
    
    public function getTotalEdges()
    {
        array_walk($this->graph, function($vertex) {
            $this->totalEdges += count($vertex);
        });
        return $this->totalEdges;
    }
}

class UndirectedGraph extends Graph implements GraphType {
    public function addEdge($vertex, $vertexEdge)
    {
        array_push($this->graph[$vertex], $vertexEdge);
        array_push($this->graph[$vertexEdge], $vertex);
    }
    
    public function getTotalEdges()
    {
        array_walk($this->graph, function($vertex) {
            $this->totalEdges += count($vertex);
        });
        return $this->totalEdges/2;
    }
}

$vertices = ['A', 'B', 'C', 'D', 'E'];
echo "Directed Graph : <br/>";
$graph = new DirectedGraph($vertices);
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

echo "<br/>";
echo "<br/>";


echo "Undirected Graph : <br/>";
$graph = new UndirectedGraph($vertices);
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


?>

